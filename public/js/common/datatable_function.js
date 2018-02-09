function datatableInitWithButtonsAndDynamicRev(obj) {
    // console.log("datatable")
    var datatableObj = {
        columnDefs: [{
            orderable: false, width: '1em', targets: obj.sort_disabled_targets,
        }],
        colReorder: true,
        order: [],
        // stateSave: true,
        stateDuration:-1,
        // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
        processing: true,
        serverSide: true,
        "scrollX": true,
        ajax: {
            ajax_url : obj.ajax_url,
            data : function(d) {
                d.designation = $('.designation').val(),
                d.event = $('.event').val(),
                d.month = $('.select_month_filter').val()
                if (obj.ajax_data && obj.ajax_data != "") {
                    $.each(obj.ajax_data, function(k, v) {
                        d[k] = v
                    })
                }
            }
        },
        "columns": obj.column_data,
        "drawCallback": function( settings ) {
            var thead = $('#'+obj.table_name).find('tr:eq(0) th:eq(0)');

            if (thead.html() == "All" || thead.html() == "all") {
                $(thead).html(generateHeaderCheckbox());
            }
        }
    };

    
    if (obj.order.state) {
        datatableObj.order = [[ obj.order.column, obj.order.mode ]]
    }

    var button_dom = "";
    var buttons = [];
    
    
    if (obj.buttons.state) {
        button_dom = "<'row'<'col-sm-12 bottom-buffer'B>>";
        if (obj.buttons.colvis) {
            buttons[0] = 'colvis'
        }
        
        if (obj.buttons.excel.state) {
            buttons[1] = {

                extend: 'excelHtml5',
                // { extend: 'excelHtml5', 
                // customize: function(xlsx) { 
                //     var sheet = xlsx.xl.worksheets['sheet1.xml'];
                //     console.log(sheet);
                //     // Loop over the cells in column `F` 
                //     $('row c[r^="A"]', sheet).each( function () { 
                //         console.log(this);
                //     // Get the value and strip the non numeric characters .replace(/[^\d]/g, '')
                //         var text = $('is t', this).text();
                //         console.log('text front', $('is t', this).text(), 'text data', $('is t', this).text().replace(text, "'"+text)); 
                //         // if ( $('is t', this).text().replace(/[^\d]/g, '') * 1 >= 50000 ) { 
                //         //     $(this).attr( 's', '20' ); 
                //         // }
                //         $('is t', this).text().replace(text, "'"+text)
                //     }); 
                // },
                exportOptions: {
                    //to remove first column from export
                    // columns: function ( idx, data, node ) {
                    //     var action_col = $('thead th').index($('.thead_action'));
                    //     var isVisible = table.column( idx ).visible();
                    //    console.log(isVisible)
                    //     var isNotForExport = $.inArray( idx, action_col ) !== -1;
                       
                    //     return isVisible && !isNotForExport ? true : false;
                    // },
                    columns: obj.buttons.excel.columns,
                    // exclude: [ 0 ],
                    format: {
                        body: function ( data, column, row, node ) {
                            if ($(node).length) {
                                var status_col = $('thead th').index($('.thead_status'));
                                var action_col = $('thead th').index($('.thead_action'));
                                // console.log(status_col, action_col,$(node)[0].cellIndex)
                                if ($(node)[0].cellIndex == status_col) {
                                    return $($(node)).find('.label').text();
                                } else if ($(node)[0].cellIndex == action_col) {
                                    return ;
                                } else {
                                    if (typeof (data) == "number") {
                                        return data;
                                    } else {
                                        //added another replace to avoid execution of csv injection --AG 030817
                                        return data.replace(/<\/?[^>]+(>|$)/g, "").replace(data, "'" + data);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (obj.buttons.pdf.state) {
            buttons[2] = {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: obj.buttons.pdf.columns,
                    
                    format: {
                        body: function ( data, column, row, node ) {
                            if ($(node).length) {
                                var status_col = $('thead th').index($('.thead_status'));
                                var action_col = $('thead th').index($('.thead_action'));
                                // console.log(status_col, action_col,$(node)[0].cellIndex)
                                if ($(node)[0].cellIndex == status_col) {
                                    return $($(node)).find('.label').text();
                                } else if ($(node)[0].cellIndex == action_col) {
                                    return ;
                                } else {
                                    if (typeof (data) == "number") {
                                        return data
                                    } else {
                                        return data.replace(/<\/?[^>]+(>|$)/g, "");
                                    }
                                }
                            }
                            // return data;
                        }
                    }
                }
            }
        }
    }
    datatableObj.buttons = buttons;
    datatableObj.info = obj.info;
    datatableObj.paging = obj.paging;
    datatableObj.searching = obj.searching;
    datatableObj.ordering = obj.ordering;
    datatableObj.iDisplayLength = obj.iDisplayLength;

    datatableObj.dom = button_dom+
        "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12 bottom-buffer'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>";


    var table = $('#'+obj.table_name).DataTable(datatableObj);
    
    datatableScroll();
    datatableFooter(obj, table);
    datatableLength();
    datatableAcl(table);

    return table;
}


function datatableAcl(table) {
    $.each(table.rows(':eq(0)').data(), function() {
       // console.log(this)
   });
}

function datatableScroll() {
    // $('.dataTable').wrap('<div class="dataTables_scroll" />');
    
    // $('.dataTables_scroll').slimscroll({
    //     alwaysVisible: true,
    //     railVisible: true,
    //     axis: 'x',
    // });

}

function datatableFooter(obj, table) {
    
    $('#'+obj.table_name).closest('.dataTables_scroll').find('.dataTables_scrollFoot tfoot th').each(function () {
        var title = $(this).text();
        $(this).not('.no-search').html('<input type="text" class = "form-control input-sm" placeholder="Search '+title+'" />');
    });

    var state = table.state.loaded();
    
    if (state) {
        table.columns().eq(0).each(function (colIdx) {
            var colSearch = state.columns[colIdx].search;
            if (colSearch.search) {
                $('input', table.column(colIdx).footer()).val(colSearch.search);
            }
        });
        table.draw();
    }

    table.columns().every(function() {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.column( $(this).parent().index()).search( this.value ).draw();

            }
        });
    });
}

function datatableLength() {
    $('.dataTables_length select').addClass('chosen-lenght-select');
    chosenInit('', '5em', true, 'chosen-lenght-select');
}

function generateHeaderCheckbox() {
    var io = {};
    
    var l = $('<label />').html('&nbsp;All');

    io['type'] = "checkbox";
    io['name'] = "select_all";
    io['class'] = "styled select_all";

    var i = $('<input />', io);
    
    var d = $('<div />', {
        class : "checkbox checkbox-sharekhan"
    }).append(i).append(l);
    

    return $(d).get(0).outerHTML;
}

function datatableColumn(arr, action_obj = [], pk = "id") {
    var obj = [];
    arr.forEach(function(k) {
        if (k == "action" || k == "all" || k == "expand" || k == "event_operation" || k == "lead_operation" || k == "batch_action" || k == "leadbatch" || k == 'user_action') {
            obj.push(action(action_obj, pk, k))
        } else if (k == "status") {
            obj.push(status(k))
        }else if (k == "audit_flag") {
            obj.push(status(k))
        } else {
            obj.push(data(k))
        }
    });
    return obj;

    function action(action_obj, pk, view_type) {
        // console.log(view_type);
        return {
            "data": "action",
            "searchable": false,

            "sortable": false,
            "render": function (data, type, full, meta) {  
                if (view_type == "action") {
                    return generateActionIcons(action_obj, full, pk);
                } 
                if (view_type == "event_operation") {
                    return generateEventRequestActionIcons(action_obj, full, pk);
                }
                if (view_type == "expand") {
                    return generateImageIcon(pk, full);
                }
                if (view_type == "all") {
                    return generateCheckbox(pk, full);
                }
                if (view_type == "lead_operation") {
                    return generateLeadRequestActionIcons(action_obj, full, pk);  
                }
                if (view_type == "batch_action") {
                    return generateBatchRequestActionIcons(action_obj, full, pk);
                }
                if (view_type == "call_action") {
                    return generateCallRequestActionIcons(action_obj, full, pk);
                }
                if(view_type == "leadbatch"){
                   return generateLeadBatchRequestActionIcons(action_obj, full, pk); 
                }
                if(view_type == "user_action"){
                   return generateUserActionIcons(action_obj, full, pk); 
                }
            }
        }
    }

    function status(k) {
        
        return {
            "data": k,
            "searchable": true,
            "render": function (data, type, full, meta) {
                var class_name = "";
                var s = "";
                // console.log(full[pk]);
                if (full.status) {
                    if (lang.status[full.status].SHOW) {
                        s += generateDropdown(lang.status[full.status].OPTION, '', '', 'status_dropdown hide');
                        class_name = "label_dropdown";
                    } else {
                        class_name = "";
                    }
                    s += '<span data-type = "'+k+'" data-url = "'+window.location.href+'/'+full[pk]+'" data-id = "'+full[pk]+'" class="label '+class_name+'" style="color:'+lang.status[full.status].COLOR+';cursor:pointer">'+lang.status[full.status].VALUE+'</span>';
                
                    convertLabelToDropdown()
                }

                if(full.audit_flag) {
                    
                    if (lang.audit_flag[full.audit_flag].SHOW) {
                        s += generateDropdown(lang.audit_flag[full.audit_flag].OPTION, '', '', 'status_dropdown hide');
                        class_name = "label_dropdown";
                    } else {
                        class_name = "";
                    }
                    s += '<span data-type = "'+k+'" data-url = "'+window.location.href+'/'+full[pk]+'" data-id = "'+full[pk]+'" class="label '+class_name+'" style="color:'+lang.audit_flag[full.audit_flag].COLOR+';cursor:pointer">'+lang.audit_flag[full.audit_flag].VALUE+'</span>';
                
                    convertLabelToDropdown()
                }

                return s;
            }
        }
    }

    function generateDropdown(data, selected_val, name_attr, class_attr = "chosen-select") {
        var s = $('<select />', {'data-placeholder' : "Select"});
        $('<option />', { value: "", text: "" }).appendTo(s);
        for (var val in data) {
            if (val == selected_val) {
                $('<option />', { value: val, text: data[val], selected:"selected" }).appendTo(s);
            } else {
                $('<option />', { value: val, text: data[val] }).appendTo(s);
            }
        }
        $(s).val(selected_val)
        $(s).attr('class', "chosen-select " + class_attr)
        $(s).attr('name', name_attr)
        $(s).appendTo('<div />')
        return $(s).parent().html();
        //s.appendTo('#ctl00_ContentPlaceHolder1_Table1');
    }

    function generateStatusLabelDepr(pk, full) {
        var class_name = "";
        var s = "";

        if (lang.status[full.status].SHOW) {
            s += generateDropdown(lang.status[full.status].OPTION, '', '', 'status_dropdown hide');
            class_name = "label_dropdown";
        } else {
            class_name = "";
        }
        s += '<span class="label '+class_name+'" style="color:'+lang.status[full.status].COLOR+';cursor:pointer">'+lang.status[full.status].VALUE+'</span>';
        
        
        $('.status_dropdown').siblings('.chosen-container').addClass('hide');
        convertLabelToDropdown();
        return s;
    }

    function generateCheckbox(pk, full) {
        var io = {};
        var l = $('<label />');

        io['type'] = "checkbox";
        io['name'] = pk+"_chk["+full[pk]+"]";
        io['class'] = pk+"_chk styled select";
        io['data-id'] = full[pk];
        io['data-val'] = full['bank_name'];

        var i = $('<input />', io);
        
        var d = $('<div />', {
            class : "checkbox checkbox-sharekhan"
        }).append(i).append(l);
        

        return $(d).get(0).outerHTML;
    }

    //generating icons for event module
    function generateEventRequestActionIcons(ob, full, pk) {
        var status = full.request_status_id;
        var claim_status = full.claim_flag;
        var event_status = full.event_raise;
        var claim_flag = full.claim_flag;
        // console.log(claim_flag);
        var str = "";
        // console.log(status, full.event_details_id,'Process');
        var d = new Date().getTime();
        var event_date = new Date(full.event_start).getTime();
        $.each(ob, function(k, v) {

            //approval of claims to be ignored
            if(lang.screen_name === "claim_incentives_index" && claim_status !== "approved") {
                if(v.class === "claim_approve" && claim_flag != "rejected") {
                    generate(k, v, full, pk);
                }
            }

            if (status == 1) {
                if (v.class == "view_event" || v.class == "in_loop" || (v.class == "process" && full.event_process_flag == 1) ) {
                    generate(k, v, full, pk);
                }
            }
            if (status == 2) {
                if ((v.class == "schedule" && full.event_schedule_i != 0) || v.class == "view_event" || v.class == "in_loop") {
                    generate(k, v, full, pk);
                }
            }

            if (status == 3) {
                if (v.class == "view_event") {
                    generate(k, v, full, pk);
                }
            }

            if (status == 4) {
                if (v.class == "scheduleConfirm" || v.class == "view_event") {
                    generate(k, v, full, pk);
                }
            }

            if (status == 5) {
                
            }

            if (status == 6) {

            }

            if (status == 7) {
                if ((v.class == "assets" && full.event_assets_i != 0) || v.class == "adminAssets" || v.class == "view_event") {
                    generate(k, v, full, pk);
                }
            }

            if (status == 8) {
                if ((v.class == "assets" && full.event_assets_i != 0 )|| v.class == "adminAssets" || v.class == "view_event" || v.class == "eventFullEdit" || v.class == "eventFullReject") {
                    generate(k, v, full, pk);
                }
            }
            // if (status == 8) {
            //     if ((v.class == "assets" && full.event_assets_i != 0 )|| v.class == "adminAssets" || v.class == "view_event" ||v.class == "eventFullReject") {
            //         generate(k, v, full, pk);
            //     }
            //     if(event_date >= d)
            //     {
            //         if(v.class == "eventFullEdit")
            //         {
            //             generate(k, v, full, pk);
            //         }
            //     }
            // }

            if (status == 9) {
                if(v.class == "assetsConfirm" || v.class == "adminAssets" || v.class == "view_event"){
                    generate(k, v, full, pk);
                }
            }

            if (status == 10) {
                if(v.class == "view_event" ||  v.class == "adminAssets"){
                    generate(k, v, full, pk);
                }
            }

            if (status == 12) {
                if(v.class == "view_event"){
                    generate(k, v, full, pk);
                }   
            }

            if (status == 13) {
                if(v.class == "view_event" || (v.class == "schedule" && full.event_schedule_i != 0  )){
                    generate(k, v, full, pk);
                }
            }

            if (status == 14) {
                if(v.class == "view_event") {
                    generate(k, v, full, pk);
                }
            }

            if (status == 15) {
                // console.log(full.pstatus)
                if(v.class == "eventFullEdit" || v.class == "view_event" || v.class == "adminAssets" || (v.class == "assets" && full.event_assets_i != 0)) {
                    generate(k, v, full, pk);
                }
            }
            if (status == 17) {
                // console.log(full.pstatus)
                if(v.class == "eventFullEdit" || v.class == "assetsConfirm" || v.class == "view_event" || v.class == "adminAssets" || (v.class == "assets" && full.event_assets_i != 0)) {
                    generate(k, v, full, pk);
                }
            }
            // if (status == 15) {
            //     if(v.class == "view_event") {
            //         generate(k, v, full, pk);
            //     }
            //     if(event_date >= d)
            //     {
            //         console.log(event_date, d ,"date")
            //         if(v.class == "eventFullEdit")
            //         {
            //             generate(k, v, full, pk);
            //         }
            //     }
            // }

            function generate(k, v, full, pk) {
                var a = "";
                var  o = {};
                
                var i = $('<i />', {
                    class : v.i.class
                });

                o['class'] = v.class;
                o['title'] = v.title;
                o['data-original-title'] = v.title;
                o['data-id'] = full[pk];
                o['data-url'] = window.location.href+'/'+full[pk]+v.url;
                if (v.href) {
                    o['href'] = window.location.href+'/'+full[pk]+v.url;
                }
                o['html'] = i;
                a = $('<a />', o);
                
                str += $(a).get(0).outerHTML;
            }
        })

        return str;
    }

    function generateLeadBatchRequestActionIcons(ob, full, pk){
        var mentorname = full.mmr_name;
        var batchid = full.batch_name;
        var hours = full.hours;
        var profiling = full.profiling_flag;
        var call_history = full.call_history;
        var batch_change_request_flag = full.batch_change_request_flag;
        var str = "";
        // console.log(call_history);
        $.each(ob, function(k, v) {
            if (v.class === 'trade' || (v.class === 'batch-call-logger' && (mentorname == null || mentorname == undefined ) && batchid == null && (call_history == null || call_history != "Answered" )) || (v.class === "client-profile" && profiling == 'Activate' )|| v.class === "resend-email" || (v.class === "request_change" &&  ((mentorname != null ||mentorname != 0) && (batchid != null || batchid != 0 ) && batch_change_request_flag != "Request" )) ) {
                generate(k, v, full, pk);
                // console.log(v)
                function generate(k, v, full, pk) {
                    var a = "";
                    var  o = {};
                    var url = window.location.href;
                    var params = refineUrl(url);
                    if(params != "") {
                        url = url.replace(params, "").replace("?", "");
                    }
                    
                    var i = $('<i />', {
                        class : v.i.class
                    });

                    o['class'] = v.class;
                    o['title'] = v.title;
                    o['data-original-title'] = v.title;
                    o['data-id'] = full[pk];
                    o['data-target'] = v.target;
                    o['data-toggle'] = v.toggle;
                    o['data-url'] = url+'/'+full[pk]+v.url;
                    if (v.href) {
                        o['href'] = url+'/'+full[pk]+v.url;
                    }
                    o['html'] = i;
                    a = $('<a />', o);
                    
                    str += $(a).get(0).outerHTML;
                }
                    // to retrive params from url AG 15-04-17
                    function refineUrl() {
                        //get full url
                        var url = window.location.href;
                        //get url after/
                        var value = url.substring(url.lastIndexOf('/') + 1);
                        //get the part after before ?
                        value  = value.split("?")[1];   
                        return value;     
                    }
            }
        });

        return str;
    }

    function generateUserActionIcons(ob, full, pk){
        var status = full.status;
        // console.log(status,'profiling');
        var str = "";
        $.each(ob, function(k, v) {
            if ((v.class == 'edit' && status != 'closed') || v.class == 'view') {
                generate(k, v, full, pk);
                // console.log(v)
                function generate(k, v, full, pk) {
                    var a = "";
                    var  o = {};
                    var url = window.location.href;
                    var params = refineUrl(url);
                    if(params != "") {
                        url = url.replace(params, "").replace("?", "");
                    }
                    
                    var i = $('<i />', {
                        class : v.i.class
                    });

                    o['class'] = v.class;
                    o['title'] = v.title;
                    o['data-original-title'] = v.title;
                    o['data-id'] = full[pk];
                    o['data-target'] = v.target;
                    o['data-toggle'] = v.toggle;
                    o['data-url'] = url+'/'+full[pk]+v.url;
                    if (v.href) {
                        o['href'] = url+'/'+full[pk]+v.url;
                    }
                    o['html'] = i;
                    a = $('<a />', o);
                    
                    str += $(a).get(0).outerHTML;
                }
                    // to retrive params from url AG 15-04-17
                    function refineUrl() {
                        //get full url
                        var url = window.location.href;
                        //get url after/
                        var value = url.substring(url.lastIndexOf('/') + 1);
                        //get the part after before ?
                        value  = value.split("?")[1];   
                        return value;     
                    }
            }
        });

        return str;
    }

    //generating icons for lead module
    function generateLeadRequestActionIcons(ob, full, pk) {
        var pending_amount_status = $(full.pending_amount).text();
        var dstatus = full.document_status;
        var pstatus = full.payment_mode;
        var sl_recon_status = full.sl_reocn_status;
        var recon_status = full.recon_status
        // console.log(sl_recon_status);
        var discount_flag = full.avail_discount_flag;
        var str = "";
        var s2kid = full.s2kid;
        var signup_objection = full.objection_flag_desc;

        $.each(ob, function(k, v) {
            if ((v.class == 'UNPAID' && parseInt(pending_amount_status) > 0) || dstatus === v.class || (v.class === "signup_edit" && recon_status != "reconciled" && discount_flag != 2) || (v.class === "cash_slip" && pstatus === "Cash") || v.class === "advance_signup" || (discount_flag == 2  && v.class == 'add_discount') || (v.class == "signup_objection" && s2kid == undefined && (signup_objection == 'No Objection' || signup_objection == 'Objection Removed'))) {
                generate(k, v, full, pk);

                function generate(k, v, full, pk) {
                    var a = "";
                    var  o = {};
                    var url = window.location.href;
                    var params = refineUrl(url);
                    if(params != "") {
                        url = url.replace(params, "").replace("?", "");
                    }
                    
                    var i = $('<i />', {
                        class : v.i.class
                    });

                    o['class'] = v.class;
                    o['title'] = v.title;
                    o['data-original-title'] = v.title;
                    o['data-id'] = full[pk];
                    o['data-target'] = v.target;
                    o['data-toggle'] = v.toggle;
                    o['data-url'] = url+'/'+full[pk]+v.url;
                    if (v.href) {
                        o['href'] = url+'/'+full[pk]+v.url;
                    }
                    o['html'] = i;
                    a = $('<a />', o);
                    
                    str += $(a).get(0).outerHTML;
                }
                    // to retrive params from url AG 15-04-17
                    function refineUrl() {
                        //get full url
                        var url = window.location.href;
                        //get url after/
                        var value = url.substring(url.lastIndexOf('/') + 1);
                        //get the part after before ?
                        value  = value.split("?")[1];   
                        return value;     
                    }
            }
        });

        return str;
    }

    //generating icons for Welcome Call module
    function generateCallRequestActionIcons(ob, full, pk) {
        var icon = full.pool_bucket;
        var str = "";
        
        $.each(ob, function(k, v) {
            if (v.class === "assign_credentials" && icon == 0 ) {
                
                generate(k, v, full, pk);

                function generate(k, v, full, pk) {
                    var a = "";
                    var  o = {};
                    var url = window.location.href;
                    var params = refineUrl(url);
                    if(params != "") {
                        url = url.replace(params, "").replace("?", "");
                    }
                    
                    var i = $('<i />', {
                        class : v.i.class
                    });

                    o['class'] = v.class;
                    o['title'] = v.title;
                    o['data-original-title'] = v.title;
                    o['data-id'] = full[pk];
                    o['data-target'] = v.target;
                    o['data-toggle'] = v.toggle;
                    o['data-url'] = url+'/'+full[pk]+v.url;
                    if (v.href) {
                        o['href'] = url+'/'+full[pk]+v.url;
                    }
                    o['html'] = i;
                    a = $('<a />', o);
                    
                    str += $(a).get(0).outerHTML;
                }
                    // to retrive params from url AG 15-04-17
                    function refineUrl() {
                        //get full url
                        var url = window.location.href;
                        //get url after/
                        var value = url.substring(url.lastIndexOf('/') + 1);
                        //get the part after before ?
                        value  = value.split("?")[1];   
                        return value;     
                    }
            }
        });

        return str;
    }

    //generating icons for Batch module
    function generateBatchRequestActionIcons(ob, full, pk) {
        var icon = full.pool_bucket;
        var str = "";
        var username = full.username;
        var test_id = full.test_id;
        var batchid = full.batch_name; 
        var status_mtc = full.status_flag;
        var ec_bucket = full.ec_bucket;
        var mtc_signup_flag = full.mtc_signup_flag;
        // console.log(status_mtc,ec_bucket ,mtc_signup_flag);
        $.each(ob, function(k, v) {
            if ((v.class === "assign_credentials" && icon == 0 && test_id == 0) ||(v.class === "send_credentials" && username == null) || (v.class === "batch-call-logger" && status_mtc == 3  && ec_bucket != 0 ) || (v.class === "batch-call-logger-mentor" && status_mtc == 3  && ec_bucket != 0 ) || (v.class === "batch-call-logger-mentor" &&  ec_bucket == 1 || ec_bucket == 0)  || (v.class === "batch-call-logger" &&  ec_bucket == 0) ||(v.class === "signup" && status_mtc == 1 && ec_bucket == 1 && mtc_signup_flag == 0)  || (v.class === "signup_mentor" && status_mtc == 1  &&  ec_bucket == 2 && mtc_signup_flag == 0)|| (v.class === "register_credentials" && batchid != "")) {
                
                generate(k, v, full, pk);

                function generate(k, v, full, pk) {
                    var a = "";
                    var  o = {};
                    var url = window.location.href;
                    var params = refineUrl(url);
                    if(params != "") {
                        url = url.replace(params, "").replace("?", "");
                    }
                    
                    var i = $('<i />', {
                        class : v.i.class
                    });

                    o['class'] = v.class;
                    o['title'] = v.title;
                    o['data-original-title'] = v.title;
                    o['data-id'] = full[pk];
                    o['data-target'] = v.target;
                    o['data-toggle'] = v.toggle;
                    o['data-url'] = url+'/'+full[pk]+v.url;
                    if (v.href) {
                        o['href'] = url+'/'+full[pk]+v.url;
                    }
                    o['html'] = i;
                    a = $('<a />', o);
                    
                    str += $(a).get(0).outerHTML;
                }
                    // to retrive params from url AG 15-04-17
                    function refineUrl() {
                        //get full url
                        var url = window.location.href;
                        //get url after/
                        var value = url.substring(url.lastIndexOf('/') + 1);
                        //get the part after before ?
                        value  = value.split("?")[1];   
                        return value;     
                    }
            }
         else if(v.class === "assign_credentials" && icon != 0 && test_id == 1)
         {
            generate(k, v, full, pk);

                function generate(k, v, full, pk) {
                    var a = "";
                    var  o = {};
                    var url = window.location.href;
                    var params = refineUrl(url);
                    if(params != "") {
                        url = url.replace(params, "").replace("?", "");
                    }
                    
                    var i = $('<i />', {
                        class : v.i.class
                    });

                    o['class'] = v.class;
                    o['title'] = v.title;
                    o['data-original-title'] = v.title;
                    o['data-id'] = full[pk];
                    o['data-target'] = v.target;
                    o['data-toggle'] = v.toggle;
                    o['data-url'] = url+'/'+full[pk]+v.url;
                    if (v.href) {
                        o['href'] = url+'/'+full[pk]+v.url;
                    }
                    o['html'] = i;
                    a = $('<a />', o);
                    
                    str += $(a).get(0).outerHTML;
                }
                    // to retrive params from url AG 15-04-17
                    function refineUrl() {
                        //get full url
                        var url = window.location.href;
                        //get url after/
                        var value = url.substring(url.lastIndexOf('/') + 1);
                        //get the part after before ?
                        value  = value.split("?")[1];   
                        return value;     
                    }
         }
        });

        return str;
    }

    function generateActionIcons(ob, full, pk) {
        var icon = full.status_flag;
        // console.log(icon,'status_flag');
        var str = ""
        $.each(ob, function(k, v) {
            var a = "";
            var  o = {};
            
            var i = $('<i />', {
                class : v.i.class
            });
            o['class'] = v.class;
            o['title'] = v.title;
            o['data-original-title'] = v.title;
            o['data-id'] = full[pk];
            o['data-target'] = v.target;
            o['data-toggle'] = v.toggle;
            o['data-url'] = window.location.href+'/'+full[pk]+v.url;
            if (v.href == "true" || v.href == true) {
                
                o['href'] = window.location.href+'/'+full[pk]+v.url;
            }
            if (v.href == "manual") {
                var pathArray = window.location.pathname.split( '/' );
                o['href'] = "/";
                for(var j = 1; j <= v.href_limit; j++) {
                    o['href'] += pathArray[j] + "/";
                }
                o['href'] += full[pk]+v.url;
            }
            o['html'] = i;
            a = $('<a />', o);
            
            str += $(a).get(0).outerHTML;
        })

        return str;
    }

    function generateImageIcon(pk, full) {
        var o = {};
        o["data-id"] = full[pk];
        o["data-type"] = full['type'];
        o["class"] = "center expand_image";
        o['src'] = "/img/plus.png";
        var img = $('<img />', o);
        return $(img).get(0).outerHTML;
    }

    function data(k) {
        return {
            "data": k,
            "searchable": true,

            "render": function (data, type, full, meta) {
                return data;
            }
        }
    }
}

    function convertLabelToDropdown() {
        $(document).on('click', '.label_dropdown', function() {
            chosenInit('','50%',false,'chosen-select');
            $('.status_dropdown').siblings('.chosen-container').addClass('hide');
            $('.label_dropdown').removeClass('hide');
            $('.status_dropdown').addClass('hide');
            $('.status_dropdown').siblings('.chosen-container').addClass('hide');
            $(this).addClass('hide');
            $(this).siblings('select').removeClass('hide');
            $(this).siblings('.chosen-container').removeClass('hide');
        });
    }

    function statusChange() {
        var table = this.table;
        $(document).on('change', '.status_dropdown', function() {
            var check_val = window.location.href.split("/").pop();
            var that = $(this);
            var dropdown = $(this).siblings('span');
            if($(this).val() == 'CLOSED'){
                var message = 'ARE YOU SURE WANT TO CLOSE THE STATUS ? ONCE CLOSED CANNOT BE CHANGED.';
                var className = 'bootbox-red';
            }
            else
            {
                var message = 'ARE YOU  SURE WANT TO CHANGE THE STATUS ?';
                var className = '';
            }
            bootbox.confirm({
                message : message ,
                className :  className ,
                callback : function(result) {
                    if (result) {
                        $.ajax({
                            type : 'put',
                            url : $(dropdown).data('url'),
                            data : {
                                type : $(dropdown).data('type'),
                                status : $(that).val()
                            },
                            success : function(data) {
                                $(that).addClass('hide');
                                $(that).siblings('.chosen-container').addClass('hide');
                                $(that).siblings('span').removeClass('hide');
                                $(that).siblings('span').html($(that).val());
                            if(check_val == "audit-master"){
                                $(that).siblings('span').css('color',lang.audit_flag[$(that).val().toLowerCase()].COLOR);
                            } else {
                                $(that).siblings('span').css('color',lang.status[$(that).val().toLowerCase()].COLOR);
                            }
                                table.draw();
                            },
                            error : function(res) { 
                                if(res.status == 401) {
                                   bootbox.alert({
                                        title: "Error Unauthorized Access",
                                        message: "You are not authorized to do this operation. Contact Admin",
                                        backdrop: true
                                    });
                                }
                            }
                        });
                    } else {
                        $('.status_dropdown').siblings('.chosen-container').addClass('hide');
                        $('.label_dropdown').removeClass('hide');
                        $('.status_dropdown').addClass('hide');
                        $('.status_dropdown').siblings('.chosen-container').addClass('hide');
                    }
                }
            });
        })
    }

    function changeRowColor(column, value, table_obj,table = "#table") {
        table_obj.on('draw', function(e) {
            var val = $(table).find('.'+column);
            var index = $(table).find('th').index(val);
            $(table).find('tbody tr').each(function(k,v) {

                var text = $(v).find('td').eq(index).text();
                $.each(value, function(k1, v1) {
                    if (text == k1) {
                        $(v).css('color', v1)
                    }
                });
            })
        })
    }

/*To change the row color of lead batch allocation blade if after 24 hour calling is not completed*/
    function changeBatchRowColor(column1,column2,column3, value, table_obj,table = "#table") {
        table_obj.on('draw', function(e) {
            var val = $(table).find('.'+column);
            var index = $(table).find('th').index(val);
            $(table).find('tbody tr').each(function(k,v) {

                var text = $(v).find('td').eq(index).text();
                $.each(value, function(k1, v1) {
                    if (text == k1) {
                        $(v).css('color', v1)
                    }
                });
            })
        })
    }

    function changeRowColorGeneral(column, value, table_obj,table = "#table") {
        table_obj.on('draw', function(e) {
            var val = $(table).find('.'+column);
            var index = $(table).find('th').index(val);
            $(table).find('tbody tr').each(function(k,v) {

                var text = $(v).find('td').find('span').text().toLowerCase();
                $.each(value, function(k1, v1) {
                    if (text == k1) {
                        $(v).css('color', v1)
                    }
                });
            })
        })
    }

    function removeRowIcon(column, value, table_obj, table = "#table") {

        table_obj.on('draw', function(e) {
            var val = $(table).find('.'+column);
            var index = $(table).find('th').index(val);
            $(table).find('tbody tr').each(function(k,v) {

                var text = $(v).find('td').eq(index).text();
                $.each(value, function(k1, v1) {
                    if (text == k1) {
                        $(v).find('.'+ v1).remove();
                    }
                });
            })
        })
    }

    function generateThRow(arr) {
        var data = "";
        for (var i = 0; i < arr.length; i++) {
            var th = $('<th />', {
                class : "thead_" + arr[i],
                html : arr[i].replace(/_/g, ' ')
            });
            data += th.prop('outerHTML')
        }
        return data;
    }

    function nestingDatatable(obj, that, th) {
        // console.log(obj, that, th);
        function fnFormatDetails(table_id, html) {
            var sOut = "<table id=\"table_" + table_id + "\" class = 'table display compact table-striped table-bordered hover nowrap' cellspacing='0' role='grid' width='100%'>";
            // var sOut = "<table id=\"inner_table\">";
            sOut += "<thead>";
                sOut += "<tr>";
                    sOut += html;
                sOut += "</tr>";
            sOut += "</thead>";
            sOut += "<tfoot>";
                sOut += "<tr>";
                    sOut += html;
                sOut += "</tr>";
            sOut += "</tfoot>";
            sOut += "</table>";
            
            return sOut;
        }

        var iTableCounter = Math.floor((Math.random() * 10000));
        var oInnerTable;
        var TableHtml;
        // Run On HTML Build


        // $(document).on('click', '#'+obj.table_name+' tbody td img' ,function () {
            var tr = $(that).closest('tr');
            var new_table = tr.closest('table');
            new_table = $('#' + $(new_table).attr('id')).dataTable().api();
            var row = new_table.row( tr );
            
            if ( row.child.isShown()) {
                // This row is already open - close it

                row.child.hide();
                that.src = "/img/plus.png";

            }
            else {
                // Open this row
                that.src = "/img/minus.png";
                
                row.child( fnFormatDetails(iTableCounter, th) ).show();
                
                tr.addClass('shown');
                
                obj.table_name = "table_"+iTableCounter;
                
                
                datatableInitWithButtonsAndDynamicRev(obj);
                
                $("#table_" + iTableCounter+"_wrapper").css("padding", "1em");
                
                iTableCounter = iTableCounter + 1;
            } 
        // })

    }

    function datatableInitWithButtonsAndDynamicNesting(obj) {
        var oTable = datatableInitWithButtonsAndDynamicRev(obj);
        nestingDatatable(obj, oTable);
        // console.log(oTable,'obj');
    }

