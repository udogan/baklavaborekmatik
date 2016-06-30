var BaklavaBorekMatik = {
    translations: {
        "Show _MENU_ entries": "Sayfa başına _MENU_ satır göster",
        "No data available in table": "Tabloda gösterilecek veri yok",
        "Showing _START_ to _END_ of _TOTAL_ entries": "Toplam _TOTAL_ satırdan _START_ ile _END_ arası gösteriliyor",
        "Showing 0 to 0 of 0 entries": "Toplam 0 satırdan 0 ile 0 arası gösteriliyor",
        "(filtered from _MAX_ total entries)": "(toplam _MAX_ satırdan filtrelendi)",
        "Search:": "Ara:",
        "Previous": "Önceki",
        "Next": "Sonraki",
        "Finish": "Bitti"
    },
    __: function(key) {
        if (!!this.translations) {
            return (this.translations[key] ? this.translations[key] : key);
        } else {
            return key;
        }
    },
    defaultDataTableOptions: function() {
        return {
            "language": {
            "lengthMenu": this.__("Show _MENU_ entries"),
                "zeroRecords": this.__("No data available in table"),
                "info": this.__("Showing _START_ to _END_ of _TOTAL_ entries"),
                "infoEmpty": this.__("Showing 0 to 0 of 0 entries"),
                "infoFiltered": this.__("(filtered from _MAX_ total entries)"),
                "search": this.__("Search:"),
                "paginate": {
                "previous": this.__("Previous"),
                    "next": this.__("Next")
                }
            }
        };
    },
    addItemFormDeleteLink: function(tagFormLi) {
        var removeFormA = $('<a href="javascript:void(0)">' + this.__('Delete this item') + '</a>');
        tagFormLi.append(removeFormA);

        removeFormA.on('click', function(e) {
            e.preventDefault();
            tagFormLi.remove();
        });
    },
    addItemToOrderForm: function(collectionHolder, newLinkLi) {
        var prototype = collectionHolder.data('prototype');

        var index = collectionHolder.data('index');
        var newForm = prototype.replace(/__name__/g, index);

        collectionHolder.data('index', index + 1);
        var newFormLi = jQuery('<li></li>').append(newForm);
        newLinkLi.before(newFormLi);
        this.addItemFormDeleteLink(newFormLi);
    },
    prepareOrderFormItems: function() {
        var collectionHolder;
        var self = this;

        var addTagLink = jQuery('<a href="javascript:void(0)" class="add_order_item_link">' + this.__('Add an item') + '</a>');
        var newLinkLi = jQuery('<li></li>').append(addTagLink);

        collectionHolder = jQuery('#order-form-wrapper ul.items');

        collectionHolder.find('> li').each(function() {
            self.addItemFormDeleteLink(jQuery(this));
        });

        collectionHolder.append(newLinkLi);

        collectionHolder.data('index', collectionHolder.find(':input').length);

        addTagLink.on('click', function(e) {
            e.preventDefault();
            self.addItemToOrderForm(collectionHolder, newLinkLi);
        });
    },
    onReady: function() {
        var self = this;
        var userDataTable = jQuery.extend(this.defaultDataTableOptions(), {"order": [4, "desc"]});
        jQuery(".user-data-table").dataTable(userDataTable);

        var orderDataTable = jQuery.extend(this.defaultDataTableOptions(), {"order": [3, "desc"]});
        jQuery(".order-data-table").dataTable(orderDataTable);

        var measurementDataTable = jQuery.extend(this.defaultDataTableOptions(), {"order": [3, "desc"]});
        jQuery(".measurement-data-table").dataTable(measurementDataTable);

        var productDataTable = jQuery.extend(this.defaultDataTableOptions(), {"order": [3, "desc"]});
        jQuery(".product-data-table").dataTable(productDataTable);

        if (jQuery("#order-form-wrapper").length) {
            this.prepareOrderFormItems();
        }

        if (jQuery("#dashboard-calendar").length) {
            var calendar = jQuery('#dashboard-calendar').fullCalendar({
                lang: 'tr',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function(calEvent, jsEvent, view) {
                    jQuery('#dashboard-calendar-edit').click();
                    jQuery('#dashboard-calendar-detail-name-surname').html(calEvent.title);
                    jQuery('#dashboard-calendar-detail-items').html(calEvent.items.join("<br>"));
                    calendar.fullCalendar('unselect');
                },
                editable: true,
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: 'getCalendarEvents',
                        dataType: 'json',
                        data: {
                            start: start.unix(),
                            end: end.unix()
                        },
                        success: function(response) {
                            if (!!response.result && response.result.length) {
                                var events = [];
                                jQuery.each(response.result, function(i, el) {
                                    events.push({
                                        title: el.nameSurname,
                                        start: el.date,
                                        items: el.item
                                    });
                                });
                                callback(events);
                            }
                        }
                    });
                }
            });
        }
    }
};

jQuery(document).ready(jQuery.proxy(BaklavaBorekMatik.onReady, BaklavaBorekMatik));