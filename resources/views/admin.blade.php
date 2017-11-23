<!doctype html>
<html lang="en">

<head>
	<title>Image Administration</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
	 crossorigin="anonymous">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script>
	$(function () {
        $('#next-button').click(function () {
            $.get( '{{ route('next') }}', function(data, status){
                location.reload();
            });
        });
    });

</script>
<style>
	#next-button {
		background-color: #957bbe;
		border-radius: 1rem;
		color: white;
		text-align: center;
		vertical-align: middle;
		font-family: sans-serif;
		line-height: 10rem;
		font-size: 2rem;
		padding-top: 1rem;
		padding-bottom: 1rem;
	}

	.border {
		margin: 1rem;
	}

	.img-col-width {
		width: 100%;
	}

	.images {
		margin-top: 20px;
	}

	.pagination {
		padding: 20px;
	}
</style>

<body class="border">
	<div>
		<div id="next-button" class="container-fluid">
			<h1>Next</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			{{ $images->links('pagination::bootstrap-4') }}
		</div>
	</div>

	<div class="container-fluid images">
		@foreach ($images as $image)
		<div class="row">
			<div class="col-6">
				<img class="img-col-width" src="{{ route('image-id', ['id' => $image->id])}}" />
			</div>
			<div class="col">
				{{$image->path}}
			</div>
		</div>
		@endforeach
	</div>
	<div class="row">
		<div class="col-12">
			{{ $images->links('pagination::bootstrap-4') }}
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
	 crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
	 crossorigin="anonymous"></script>
</body>

</html>