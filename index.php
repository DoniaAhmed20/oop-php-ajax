<html>

<head>
    <link rel="stylesheet" href="components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="components/jquery-confirm-master/css/jquery-confirm.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

</head>
<body>


<nav class="nav navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header" align="center">
            <a class="navbar-brand" href="#"><b>Simple Student Management Crud</b></a>
        </div>
    </div>
</nav>

</br></br>

<div class="container-fluid bg-2 text-center">
    <div class="row">

        <div class="col-sm-4">

            <form id="frmProject" name="frmProject">

                <div class="form-group" align="left">
                    <label class="form-label">Student Name</label>
                    <input type="text" class="form-control" placeholder="Student Name" id="studname" name="studname" size="30px" required>
                </div>
                <div class="form-group" align="left">
                    <label class="form-label">Course</label>
                    <input type="text" class="form-control" placeholder="Course" id="course" name="course" size="30px" required>
                </div>
                <div class="form-group" align="left">
                    <label class="form-label">Fee</label>
                    <input type="text" class="form-control" placeholder="Fee" id="fee" name="fee" size="30px" required>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Version Name</label>

                    <div class="col-sm-10">
                        <select class="form-control" id="project_version_id" name="project_version_id" required>
                            <option value="">Please Selecssst</option>

                        </select>

                    </div>
                </div>



            </form>

        </div>


        <div class="col-sm-8">

            <div class="panel-body">

                <table id="tbl-projects" class="table table-responsive table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>

                </table>
            </div>

        </div>

    </div>
</div>

<script src="components/jquery/dist/jquery.js"></script>



<script src="components/jquery/dist/jquery.min.js"></script>



<script src="components/jquery-confirm-master/js/jquery-confirm.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="components/jquery.validate.min.js"></script>


<script>
    var isNew =true;
    var project_id = null;
    get_all();

    function addStudent()
    {
        if($("#frmProject").valid())
        {

            var url= '';
            var dat = '';
            var method = '';
            if(isNew == true)
            {
                url = 'add_project.php';
                data = $('#frmProject').serialize();
                method = 'POST';
            }

            else
            {
                url = 'update_project.php';
                data = $('#frmProject').serialize() + "&project_id=" + project_id;
                method = 'POST';
            }

            $.ajax({

                type : method,
                url : url,
                dataType : 'JSON',
                data : data,



                success : function (data)
                {
                    $('#frmProject')[0].reset();

                    $('#save').html('');
                    $('#save').append('Add');

                    var msg;
                    get_all();
                    if(isNew)
                    {
                        msg = "Course Created";
                    }
                    else
                    {
                        msg = "Course Updated";
                    }

                    $.alert({
                        title: 'Success!',
                        content: msg,
                        type: 'green',
                        boxWidth: '400px',
                        theme: 'light',
                        useBootstrap: false,
                        autoClose: 'ok|2000'
                    });
                    isNew = true;
                },
                error: function (xhr, status, error) {
                    alert(xhr);
                    console.log(xhr.responseText);

                    $.alert({
                        title: 'Fail!',
                        //            content: xhr.responseJSON.errors.product_code + '<br>' + xhr.responseJSON.msg,
                        type: 'red',
                        autoClose: 'ok|2000'

                    });
                    $('#save').prop('disabled', false);
                    $('#save').html('');
                    $('#save').append('Save');
                }

            });

        }
    }


    function get_all()
        {
            $('#tbl-projects').dataTable().fnDestroy();
            $.ajax({

                url : "all_project.php",
                type : "GET",
                dataType : "JSON",


                success:function(data)
                {

                    $('#tbl-projects').html(data);

                    $('#tbl-projects').dataTable({
                        "aaData": data,
                        "scrollX": true,
                        "aoColumns": [
                            {"sTitle": "StudentName", "mData": "name"},
                            {"sTitle": "Course", "mData": "course"},
                            {"sTitle": "Fee", "mData": "fee"},
                            {
                                "sTitle": "Status","mData": "status", "render": function (mData, type, row, meta) {
                                if (mData == 1) {
                                    return '<span class="label label-info">Active</span>';
                                }
                                else if (mData == 2) {
                                    return '<span class="label label-warning">Deactive</span>';
                                }
                            }
                            },
                            {
                                "sTitle": "Edit",
                                "mData": "id",
                                "render": function (mData, type, row, meta) {
                                    return '<button class="btn btn-xs btn-success" onclick="get_project_details(' + mData + ')">Edit</button>';
                                }
                            },
                            {
                                "sTitle": "Delete",
                                "mData": "id",
                                "render": function (mData, type, row, meta) {
                                    return '<button class="btn btn-xs btn-primary" onclick="Remove_details(' +  mData + ')">Delete</button>';
                                }
                            }
                        ]
                    });

                },

                error: function (xhr, status, error) {
                    alert(xhr);
                    console.log(xhr.responseText);

                    $.alert({
                        title: 'Fail!',
                        //            content: xhr.responseJSON.errors.product_code + '<br>' + xhr.responseJSON.msg,
                        type: 'red',
                        autoClose: 'ok|2000'

                    });
                    $('#save').prop('disabled', false);
                    $('#save').html('');
                    $('#save').append('Save');
                }





            });

        }




    function get_project_details(id) {
        $.ajax({
            type: 'POST',
            url: 'project_return.php',
            dataType: 'JSON',
            data: {project_id: id},
            success: function (data) {
                $("html, body").animate({scrollTop: 0}, "slow");
                isNew = false
                console.log(data);

                project_id = data.id
                $('#studname').val(data.name);
                $('#course').val(data.course);
                $('#fee').val(data.fee);
                $('#status').val(data.status);
                $('#frmProject').modal('show');
            },
            error: function (xhr, status, error) {
                alert(xhr);
                console.log(xhr.responseText);

                $.alert({
                    title: 'Fail!',
                    //            content: xhr.responseJSON.errors.product_code + '<br>' + xhr.responseJSON.msg,
                    type: 'red',
                    autoClose: 'ok|2000'

                });
            }

        });
    }


    function Remove_details(id)
    {
        $.confirm({

            theme: 'supervan',
            buttons: {

                yes : function()
                {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_project.php',
                        dataType: 'JSON',
                        data: {project_id: id},

                        success: function (data) {

                            get_all();


                        },


                        error: function (xhr, status, error) {
                            alert(xhr);
                            console.log(xhr.responseText);

                            $.alert({
                                title: 'Fail!',
                                //            content: xhr.responseJSON.errors.product_code + '<br>' + xhr.responseJSON.msg,
                                type: 'red',
                                autoClose: 'ok|2000'

                            });
                        }



                    });


                },
                no : function()
                {

                }



            }




        });

    }

</script>

</body>

</html>