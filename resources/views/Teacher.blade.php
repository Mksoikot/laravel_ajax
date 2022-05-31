<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Ajax Crud Application</title>
    <meta name="csrf_token" content="{{ csrf_token() }}">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Title</label>
                          <input type="text" class="form-control" id="title"placeholder="Job Position">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Institute</label>
                            <input type="text" class="form-control" id="institute"placeholder="Enter Your Institute Name">
                          </div>
                          <br>
                        <button type="submit" id="addBtn" onclick="addData()" class="btn btn-primary">Add</button>
                        <button type="submit" id="updateBtn" class="btn btn-primary">Update</button>
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
                data = data + "<button class='btn btn-info btn-sm mr-2'>Edit</button>"
                data = data + "<button class='btn btn-danger btn-sm'>Delete</button>"
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
      }
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
                console.log('Successfully Data Added');
            }
        })
      }
    </script>
</body>

</html>
