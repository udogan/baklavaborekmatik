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

        var productDataTable = jQuery.extend(this.defaultDataTableOptions(), {"order": [3, "desc"]});
        jQuery(".product-data-table").dataTable(productDataTable);

        var measurementDataTable = jQuery.extend(this.defaultDataTableOptions(), {"order": [3, "desc"]});
        jQuery(".measurement-data-table").dataTable(measurementDataTable);
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
    },
    preparePieChart: function () {
        var theme = {
            color: [
                '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
                '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
            ],

            title: {
                itemGap: 8,
                textStyle: {
                    fontWeight: 'normal',
                    color: '#408829'
                }
            },

            dataRange: {
                color: ['#1f610a', '#97b58d']
            },

            toolbox: {
                color: ['#408829', '#408829', '#408829', '#408829']
            },

            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.5)',
                axisPointer: {
                    type: 'line',
                    lineStyle: {
                        color: '#408829',
                        type: 'dashed'
                    },
                    crossStyle: {
                        color: '#408829'
                    },
                    shadowStyle: {
                        color: 'rgba(200,200,200,0.3)'
                    }
                }
            },

            dataZoom: {
                dataBackgroundColor: '#eee',
                fillerColor: 'rgba(64,136,41,0.2)',
                handleColor: '#408829'
            },
            grid: {
                borderWidth: 0
            },

            categoryAxis: {
                axisLine: {
                    lineStyle: {
                        color: '#408829'
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: ['#eee']
                    }
                }
            },

            valueAxis: {
                axisLine: {
                    lineStyle: {
                        color: '#408829'
                    }
                },
                splitArea: {
                    show: true,
                    areaStyle: {
                        color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: ['#eee']
                    }
                }
            },
            timeline: {
                lineStyle: {
                    color: '#408829'
                },
                controlStyle: {
                    normal: {color: '#408829'},
                    emphasis: {color: '#408829'}
                }
            },

            k: {
                itemStyle: {
                    normal: {
                        color: '#68a54a',
                        color0: '#a9cba2',
                        lineStyle: {
                            width: 1,
                            color: '#408829',
                            color0: '#86b379'
                        }
                    }
                }
            },
            map: {
                itemStyle: {
                    normal: {
                        areaStyle: {
                            color: '#ddd'
                        },
                        label: {
                            textStyle: {
                                color: '#c12e34'
                            }
                        }
                    },
                    emphasis: {
                        areaStyle: {
                            color: '#99d2dd'
                        },
                        label: {
                            textStyle: {
                                color: '#c12e34'
                            }
                        }
                    }
                }
            },
            force: {
                itemStyle: {
                    normal: {
                        linkStyle: {
                            strokeColor: '#408829'
                        }
                    }
                }
            },
            chord: {
                padding: 4,
                itemStyle: {
                    normal: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        },
                        chordStyle: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            }
                        }
                    },
                    emphasis: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        },
                        chordStyle: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            }
                        }
                    }
                }
            },
            gauge: {
                startAngle: 225,
                endAngle: -45,
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                        width: 8
                    }
                },
                axisTick: {
                    splitNumber: 10,
                    length: 12,
                    lineStyle: {
                        color: 'auto'
                    }
                },
                axisLabel: {
                    textStyle: {
                        color: 'auto'
                    }
                },
                splitLine: {
                    length: 18,
                    lineStyle: {
                        color: 'auto'
                    }
                },
                pointer: {
                    length: '90%',
                    color: 'auto'
                },
                title: {
                    textStyle: {
                        color: '#333'
                    }
                },
                detail: {
                    textStyle: {
                        color: 'auto'
                    }
                }
            },
            textStyle: {
                fontFamily: 'Arial, Verdana, sans-serif'
            }
        };

        var echartPieCollapse = echarts.init(document.getElementById('echart_pie2'), theme);
        var data_pie =  JSON.parse($("#echart_pie2").attr("data-pie"));
        var name = $.map(data_pie, function(item) {
            return item.name
        });
        echartPieCollapse.setOption({
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                x: 'center',
                y: 'bottom',
                data: name
             },
            toolbox: {
                show: true,
                    feature: {
                    magicType: {
                        show: true,
                            type: ['pie', 'funnel']
                    },
                    restore: {
                        show: true,
                            title: "Restore"
                    },
                    saveAsImage: {
                        show: true,
                            title: "Save Image"
                    }
                }
            },
            calculable: true,
            series: [{
                name: 'Area Mode',
                type: 'pie',
                radius: [25, 90],
                center: ['50%', 170],
                roseType: 'area',
                x: '50%',
                max: 40,
                sort: 'ascending',
                data: data_pie
              }]
        });
    },
    onReady: function() {
        BaklavaBorekMatik.preparePieChart();
    }
};

jQuery(document).ready(jQuery.proxy(BaklavaBorekMatik.onReady, BaklavaBorekMatik));