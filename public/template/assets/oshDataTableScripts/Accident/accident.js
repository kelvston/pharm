    // var data_managementarr =  "columns:[{data: 'employee_id' , name: 'employee_id', orderable : false, searchable : false, visible : true},{data: 'filename' , name: 'filename' ,orderable : true, searchable : true},{data: 'gender' , name: 'gender' ,orderable : true, searchable : false},{data: 'incident_type' , name: 'incident_types.name'},{data: 'fullname' , name: 'fullname', orderable : false, searchable : false},{data: 'employer' , name: 'employers.name', orderable : true, searchable : true},{data: 'incident_date' , name: 'notification_reports.incident_date', orderable : true, searchable : true},{data: 'receipt_date' , name: 'notification_reports.receipt_date', orderable : true, searchable : false},{data: 'region' , name: 'regions.name',searchable : false},{data: 'employment_category' , name: 'employment_category',searchable : false},{data: 'employer_category' , name: 'employer_category',searchable : false},{data: 'bussines_sector' , name: 'bussines_sector',searchable : false},{data: 'occupation' , name: 'occupation',searchable : false},{data: 'accident_type' , name: 'accident_type',searchable : false,visible:false},{data: 'age' , name: 'age',searchable : false},{data: 'firstname' , name: 'employees.firstname', orderable : false, searchable : true, visible : false},{data: 'middlename' , name: 'employees.middlename', orderable : false, searchable : true, visible : false},{data: 'lastname' , name: 'employees.lastname', orderable : false, searchable : true, visible : false}],"
      var $oTable = $('#notification-report-table').DataTable({
            // buttons : ['reload', 'colvis'],
            dom : 'Bfrtip',
            buttons : ['excel','csv','reset', 'reload','colvis'],
            initComplete : function () {
                $oTable.buttons().container().insertBefore('#notification-report-table');
                $("#notification-report-table").css("width","100%");
            },
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: true,
            paging: true,
            info:false,
            stateSaveCallback: function (settings, data) {
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data));
            },
            stateLoadCallback: function (settings) {
                return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance));
            },
            ajax:{
                url : 'claim_datatable',
                type : 'get',
                data: function ($d) {
                    $d.location_accident = $('select[name=location_accident]').val();
                    $d.incident = $('select[name=incident]').val();
                    $d.employee = $('select[name=employee]').val();
                    $d.employer_category = $('select[name=employer_category]').val();
                    $d.bussines_sector = $('select[name=bussines_sector]').val();
                    $d.employer = $('select[name=employer]').val();
                    $d.region = $('select[name=region]').val();
                    $d.district = $('select[name=district]').val();
                    $d.gender = $('select[name=gender]').val();
                    $d.occupation = $('select[name=occupation]').val();
                    $d.export = $('#export_0').val();
                    $d.start_age = $('#start-age').val();
                    $d.end_age = $('#end-age').val();
                    $d.employment_category = $('select[name=employment_category]').val();
                }
            },
               columns: [
                { data: 'employee_id' , name: 'employee_id', orderable : false, searchable :  false, visible : true},
                { data: 'filename' , name: 'filename' ,orderable : true, searchable : true},
                { data: 'gender' , name: 'gender' ,orderable : true, searchable : false},
                { data: 'incident_type' , name: 'incident_types.name'},
                { data: 'fullname' , name: 'fullname', orderable : false, searchable : false},
                { data: 'employer' , name: 'employers.name', orderable : true, searchable : true},
                { data: 'incident_date' , name: 'notification_reports.incident_date', orderable : true, searchable : true},
                { data: 'receipt_date' , name: 'notification_reports.receipt_date', orderable : true, searchable : false},
                { data: 'region' , name: 'regions.name',searchable : false},
                { data: 'employment_category' , name: 'employment_category',searchable : false},
                { data: 'employer_category' , name: 'employer_category',searchable : false},
                { data: 'bussines_sector' , name: 'bussines_sector',searchable : false},
                { data: 'occupation' , name: 'occupation',searchable : false},
                { data: 'accident_type' , name: 'accident_type',searchable : false,visible:false},
                { data: 'age' , name: 'age',searchable : false},
                { data: 'firstname' , name: 'employees.firstname', orderable : false, searchable : true, visible : false},
                { data: 'middlename' , name: 'employees.middlename', orderable : false, searchable : true, visible : false},
                { data: 'lastname' , name: 'employees.lastname', orderable : false, searchable : true, visible : false}
            ],

            
         
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $(nRow).click(function() {
                    document.location.href = "/workplace_risk_assesment/data_management/employee/"  + aData['employee_id'] + "/" + aData['case_no'];

                }).hover(function() {
                    $(this).css('cursor','pointer');
                }, function() {
                    $(this).css('cursor','auto');
                });
                // if (aData["accident_type"] === null) {
                //     $(nRow).remove();
                //    }else{
                //     $(nRow).show();
                //    }
            }
        });
        // $('#search-recall-notification-form').on('submit', function($e) {
        //     $oTable.draw();
        //     $e.preventDefault();
        // });
