@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Fisherman Cove resort</div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
                <div class="d-flex" id="wrapper">
                    <!-- Sidebar-->
                    <div class="border-end bg-white" id="sidebar-wrapper">
                        <div class="list-group list-group-flush">
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Dashboard</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Rooms & Suits</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Offers</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{URL::to('home')}}">Media</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Pages</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Main Header</a>
                        </div>
                    </div>
                    <!-- Page content wrapper-->
                    <div id="page-content-wrapper">
                        <!-- Top navigation-->
                        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                            <div class="container-fluid">
                                <button class="btn btn-primary" id="sidebarToggle">Hide Menu</button>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

                            </div>
                        </nav>
                        <!-- Page content-->
                        <div class="container-fluid">
                            <h3 class="mt-4">Add Multiple Images</h3>
                            <form method="post" action="{{url('upload_images')}}" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="input-group control-group" id="uploadImg">
                                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                                </div>&nbsp;
                                <div class="col-md-12" id='toggle-hide'>
                                    <div class="row" id="result" /></div>
                                </div>
                            <button type="submit" class="btn btn-primary" style="margin-top:10px">Upload new Images</button>
                            </form>                             
                        </div>
                    <?php
                    $a = 1;
                    echo '<table class="table table-bordered"><tr>';
                    foreach ($images as $key => $image) {
                        if ($a <= 5) { //number of cells in row
                            ?><td><img width="100" height="100" src="{{asset('/prismImages/'.$image->image_path)}}"></img></td>
                        <?php
                        } else {
                            echo '</tr><tr>';
                            ?>
                            <?php $a = 0;
                        }
                        $a++;
                    }
                    echo '</tr></table>';
                    ?>


                </div>
            </div>
        </div>
    </div>

</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">


window.onload = function () {

//Check File API support
    if (window.File && window.FileList && window.FileReader)
    {
        var filesInput = document.getElementById("images");

        filesInput.addEventListener("change", function (event) {

            var files = event.target.files; //FileList object
            var output = document.getElementById("result");

            for (var i = 0; i < files.length; i++)
            {
                var j=0;
                var k=0;
                var file = files[i];

                //Only pics
                if (!file.type.match('image'))
                    continue;

                var picReader = new FileReader();

                picReader.addEventListener("load", function (event) {

                    var picFile = event.target;

                    var div = document.createElement("div");
                    
                    div.innerHTML = "<a href='#' class='remove_pict' style='margin-left:10px;margin-right:30px;'><i class='fa fa-trash-o' style='font-size:25px;color:red'></i></a><img width='40'  height='40' style='margin-right:50px;'class='circularsquare' src='" + picFile.result + "'" +
                            "title='" + picFile.name + "'> \
                            <input style='margin-right:100px;margin-left:50px;' type='text' name='imageAltText" + j + "' placeholder='Image Alt Text*'> \
                            <input type='radio' id='imageTypeSlider" + j + "' name='imageTypeView" + j + "' value='Regular/Slider' checked> <label for='html'>Regular/Slider</label>\
                            <input type='radio' id='imageTypeView" + k + "' name='imageTypeView" + j + "' value='360o View'> <label for='html'>360o View</label>";
                    
                    
                    output.insertBefore(div, null);
                    div.children[0].addEventListener("click", function (event) {
                        div.parentNode.removeChild(div);
                    });
                    j++;
                    k++;
                });
                
                //Read the image
                picReader.readAsDataURL(file);
            }

        });
    }
    else
    {
        console.log("Your browser does not support File API");
    }
}

</script>
