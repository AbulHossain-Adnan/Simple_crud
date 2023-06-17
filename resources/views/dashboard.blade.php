<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="row">
    <div class="col-sm-8 m-auto">
    <div class="card">
    <div class="card-header text-white bg-primary">Header</div>
    <div class="card-body">
         <div id="success_message"></div>
        <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">add new</button>
        <table class="table">
  <thead>
    <tr>
   
      <th style="width: 20%">Name</th>
      <th style="width: 25%">Roll</th>
      <th style="width: 25%">Age</th>
      <th style="width: 30%">Action</th>

    </tr>
  </thead>
  <tbody>
   
   
  </tbody>
</table>
</div>
</div>
</div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <form method="post" action="" class="student_update"  id="formdata">
          @csrf
           <ul id="save_msgList"></ul>
       <div class="mb-1">
          <label for="exampleInputPassword1" class="form-label">Name</label>
          
          <input type="text" name="name" class="form-control" id="namee">
           <input type="hidden" name="student_id" class="form-control" id="student_id">
        </div>
        <div class="mb-1">
          <label for="exampleInputPassword1" class="form-label">Roll</label>
          <input type="text" name="roll" class="form-control" id="rolll">
        </div>
        <div class="mb-1">
          <label for="exampleInputPassword1" class="form-label">Age</label>
          <input type="text" name="age" class="form-control" id="agee">
        </div>
        
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
        <button  type="button" class="btn btn-primary" id="student_update">Update changes</button>
      </div>
      </form>
      </div>
     
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>






{{-- Student Store Script start --}}
<script>
  $('#student_update').hide();
  $('#saveBtn').show();

  
      $(document).ready(function(){
        $('body').on('submit','#formdata', function(e){
              e.preventDefault();
                let formdata= new FormData($('#formdata')[0]);
              $.ajaxSetup({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
              });
              $.ajax({
              type:"POST",
              url:"students",
              data:formdata,
              contentType:false,
              processData:false,
              success:function(response){
                if(response.status == 400){
                  $('#save_msgList').html("");
                  $('#save_msgList').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                      });
                }else{

                  $('#save_msgList').html("");
                  $('#success_message').addClass('alert alert-success');
                  $('#success_message').text(response.message);
                  $('#save_msgList').removeClass('alert alert-danger');

         
              $('#exampleModal').modal('hide')
               fetchstudent();
                $('#namee').val('')
                $('#agee').val('')
                $('#rolll').val('')
                }
              }
            })
          })
          })

    function fetchstudent() {
            $.ajax({
                type: "GET",
                url: "students",
                dataType: "json",
                success: function (response) {
                    $('tbody').html("");
                    $.each(response, function (key, item) {
                    $('tbody').append(`
                     <tr>
                        <th scope="row">${item.name}</th>
                        <td>${item.roll}</td>
                        <td>${item.age}</td>
                          <td>
                            <button data-id="${item.id}" value="${item.id}" class="btn btn-info editIdd editId">edit</button>
                            <button class="btn btn-success">view</button>
                            <button class="btn btn-danger" onclick="deleteId(${item.id})">delete</button>
                          </td>
                        </tr>
                        `);
                    });
                }
            });
        }
    fetchstudent();



       
</script>



<script>
    $(document).ready(function () {

        $(document).on('click', '.editId', function (e) {
            e.preventDefault();
            $('#student_update').show();
            $('#saveBtn').hide();
            var stud_id = $(this).data('id');
        
            $('#exampleModal').modal('show');
            $.ajax({
                type: "GET",
                url: "students/" + stud_id + "/edit",
                dataType: "json",
                success: function (response) {
                 $('#namee').val(response.name);
                 $('#rolll').val(response.roll);
                 $('#agee').val(response.age);
                 $('#student_id').val(response.id);
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '#student_update', function (e) {
        var student_id = $('#student_id').val();
        let formData = {
          name:$('#namee').val(),
          roll:$('#rolll').val(),
          age:$('#agee').val(),
        }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "PUT",
                url: "students/" + student_id,
                data: formData,
                dataType: "json",
                // contentType: false,
                // processData: false,
                success: function (response) {

                   $('#student_update').hide();
                   $('#saveBtn').show();
                   $('#formdata')[0].reset();
                    $('#exampleModal').modal('hide')
                     fetchstudent();
                  
                    // if (response.status == 400) {
                    //     $('#update_msgList').html("");
                    //     $('#update_msgList').addClass('alert alert-danger');
                    //     $.each(response.errors, function (key, err_value) {
                    //         $('#update_msgList').append('<li>' + err_value +
                    //             '</li>');
                    //     });
                    //     $('.update_student').text('Update');
                    // } else {
                    //     $('#update_msgList').html("");

                    //     $('#success_message').addClass('alert alert-success');
                    //     $('#success_message').text(response.message);
                    //     $('#editModal').find('input').val('');
                    //     $('.update_student').text('Update');
                    //     $('#editModal').modal('hide');
                    //     fetchstudent();
                    // }
                }
            });

        });

        $(document).on('click', '.deletebtn', function () {
            var stud_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(stud_id);
        });

        $(document).on('click', '.delete_student', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-student/" + id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_student').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_student').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchstudent();
                    }
                }
            });
        });

    });

</script>

<script>
  function deleteId(id){
    alert("This file will be deleted")

     $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
    $.ajax({
      type:"DELETE",
      url:"students/"+id,
      dataType:"json",
      success: function(response){
        console.log(response)
         fetchstudent();
      }
    })
  }
</script>



<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




</body>
</html>

    </div>
</div>
</x-app-layout>
