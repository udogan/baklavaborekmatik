var BaklavaBorekMatik = {
    translations: {
        "Show _MENU_ entries": "Sayfa başına _MENU_ satır göster",
        "No data available in table": "Tabloda gösterilecek veri yok",
        "Showing _START_ to _END_ of _TOTAL_ entries": "Toplam _TOTAL_ satırdan _START_ ile _END_ arası gösteriliyor",
        "Showing 0 to 0 of 0 entries": "Toplam 0 satırdan 0 ile 0 arası gösteriliyor",
        "(filtered from _MAX_ total entries)": "(toplam _MAX_ satırdan filtrelendi)",
        "Search:": "Ara:",
        "Previous": "Önceki",
        "Next": "Sonraki"
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
    onReady: function() {
        var userDataTable = jQuery.extend(this.defaultDataTableOptions(), {"order": [4, "desc"]});
        jQuery(".user-data-table").dataTable(userDataTable);

        jQuery('#wizard').smartWizard();
        jQuery('.buttonNext').addClass('btn btn-success');
        jQuery('.buttonPrevious').addClass('btn btn-primary');
        jQuery('.buttonFinish').addClass('btn btn-default');

        $('#single_cal3').daterangepicker({
            singleDatePicker: true,
            calender_style: "picker_3"
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });

    }
};

jQuery(document).ready(jQuery.proxy(BaklavaBorekMatik.onReady, BaklavaBorekMatik));