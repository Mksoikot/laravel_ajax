<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Ajax Crud Application</title>
    <meta name="csrf_token" content="{{ csrf_token() }}">
<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <script src="{{asset('assets/js/jquery-3.2.1.slim.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}bootstrap.min.js"></script>
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.17/sweetalert2.min.js"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>

<body>
    <div style="padding: 30px;"></div>
    <div class="container">
        <h2 style="color: red;">
            <marquee behavior="" direction="">
                Laravel Ajax Crud Application
                </marquee>
        </h2>
        <div class="row">
            <div class="col-sm-8">
              <div class="card">
                <div class="card-header">
                      <h4>All Teacher</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Title</th>
                        <th scope="col">Institute</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      {{-- <tr>
                        <td scope="row">1</td>
                        <td>Mk Soikot</td>
                        <td>Teacher</td>
                        <td>InnovationIT</td>
                        <td><button class="btn btn-info btn-sm">Edit</button>
                           <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                      </tr> --}}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <div class="card-header">
                    <span id="addT">Add New Teacher</span>
                    <span id="updateT">Update Teacher</span>
              </div>
                <div class="card-body">
                    {{-- <form> --}}
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Name</label>
                          <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Your Name">
                          <span class="text-danger" id="nameError"></span>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Title</label>
                          <input type="text" class="form-control" id="title"placeholder="Job Position">
                          <span class="text-danger" id="titleError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Institute</label>
                            <input type="text" class="form-control" id="institute"placeholder="Enter Your Institute Name">
                            <span class="text-danger" id="instituteError"></span>
                          </div>
                          <input type="hidden" id="id">
                          <br>
                        <button type="submit" id="addBtn" onclick="addData()" class="btn btn-primary">Add</button>
                        <button type="submit" id="updateBtn" onclick="updateData()" class="btn btn-primary">Update</button>
                      {{-- </form> --}}
                </div>
              </div>
            </div>
          </div>
    </div>
    <script>
      $('#addT').show();
      $('#addBtn').show();
      $('#updateT').hide();
      $('#updateBtn').hide();

      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
//   -------------------------Get All Data From Database-----------------------------------
      function allData(){
        $.ajax({
          type: "GET",
          dataType: 'json',
          url: "/teacher/all",
          success:function(response){
              var data = ""
            $.each(response, function(key, value){
                data = data + "<tr>"
                data = data + "<td>"+ value.id +"</td>"
                data = data + "<td>"+ value.name +"</td>"
                data = data + "<td>"+ value.title +"</td>"
                data = data + "<td>"+ value.institute +"</td>"
                data = data + "<td>"
                data = data + "<button class='btn btn-info btn-sm mr-2' onclick='editData("+value.id+")'>Edit</button>"
                data = data + "<button class='btn btn-danger btn-sm' onclick='deleteData("+value.id+")'>Delete</button>"
                data = data + "</td>"
                data = data + "</tr>"
            })
            $('tbody').html(data);
          }
      })
      }
      allData();
        function clearData(){
         $('#name').val('');
         $('#title').val('');
         $('#institute').val('');
         $('#nameError').text('');
         $('#titleError').text('');
         $('#instituteError').text('');
      }
    //   -------------------------Post Add Data To Database-----------------------------------
      function addData(){
         var name = $('#name').val();
         var title = $('#title').val();
         var institute = $('#institute').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                name:name,
                title:title,
                institute:institute,
                _token:'{{csrf_token()}}'
            },
            url: "/teacher/store",
            success: function(data){
                clearData();
                allData();
                //-------start alert------------
               const Msg = Swal.mixin({
                toast: true,
                position: 'top-end',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
                })
                Msg.fire({
                type: 'success',
                title: 'Data Added Success',
                })
                                //-------end alert------------
                // console.log('Successfully Data Added');
            },
            error:function(error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#titleError').text(error.responseJSON.errors.title);
                $('#instituteError').text(error.responseJSON.errors.institute);
            }
        })
      }
      // -----------------------End Store Data------------------------

       // -----------------------Start Edit Data------------------------
      function editData(id){
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/teacher/edit/'+id,
            success: function(data){
                $('#addT').hide();
                $('#addBtn').hide();
                $('#updateT').show();
                $('#updateBtn').show();

                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#title').val(data.title);
                $('#institute').val(data.institute);

                console.log(data);
            },
            error:function(error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#titleError').text(error.responseJSON.errors.title);
                $('#instituteError').text(error.responseJSON.errors.institute);
            }

        })
      }

      // -----------------------End Edit Data------------------------


      // -----------------------Start Update Data----------------------

      function updateData(){
         var id = $('#id').val();
         var name = $('#name').val();
         var title = $('#title').val();
         var institute = $('#institute').val();
         $.ajax({
             type: 'POST',
             dataType: 'json',
             data: {
                name:name,
                title:title,
                institute:institute,
                _token:'{{csrf_token()}}'
            },
            url: "/teacher/update/"+id,
            success:function(data){
                $('#addT').show();
                $('#addBtn').show();
                $('#updateT').hide();
                $('#updateBtn').hide();
                clearData();
                allData();
            const Msg = Swal.mixin({
                toast: true,
                position: 'top-end',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
                })
                Msg.fire({
                type: 'success',
                title: 'Data Update Success',
                })
            },
            error:function(error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#titleError').text(error.responseJSON.errors.title);
                $('#instituteError').text(error.responseJSON.errors.institute);
            }
         })
      }
      // -----------------------End Update Data------------------------

      // -----------------------Start Delete Data------------------------
      function deleteData(id){
          swal({
            title: 'Are you sure to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            buttons:true,
            dangerMode:true,
          })
          .then((willDelete)=>{
              if(willDelete){
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id:id,
                        _token:'{{csrf_token()}}'
                    },
                    url: '/teacher/destroy/'+id,
                    success: function(data){
                        $('#addT').show();
                        $('#addBtn').show();
                        $('#updateT').hide();
                        $('#updateBtn').hide();
                        clearData();
                        allData();
                    const Msg = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                        })
                        Msg.fire({
                        type: 'success',
                        title: 'Data Delete Success',
                        })
            // console.log('Data Delete Success');
            },
            error:function(error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#titleError').text(error.responseJSON.errors.title);
                $('#instituteError').text(error.responseJSON.errors.institute);
            }



        })
              }else{
                  swal('Canceled');
              }
          });
        // $.ajax({
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {
        //         id:id,
        //         _token:'{{csrf_token()}}'
        //     },
        //     url: '/teacher/destroy/'+id,
        //     success: function(data){
        //         $('#addT').show();
        //         $('#addBtn').show();
        //         $('#updateT').hide();
        //         $('#updateBtn').hide();
        //         clearData();
        //         allData();
        //     const Msg = Swal.mixin({
        //         toast: true,
        //         position: 'top-end',
        //         icon: 'success',
        //         showConfirmButton: false,
        //         timer: 1500
        //         })
        //         Msg.fire({
        //         type: 'success',
        //         title: 'Data Delete Success',
        //         })
        //     // console.log('Data Delete Success');
        //     },
        //     error:function(error){
        //         $('#nameError').text(error.responseJSON.errors.name);
        //         $('#titleError').text(error.responseJSON.errors.title);
        //         $('#instituteError').text(error.responseJSON.errors.institute);
        //     }



        // })
      }
      // -----------------------End Delete Data------------------------


    </script>
</body>

</html>
