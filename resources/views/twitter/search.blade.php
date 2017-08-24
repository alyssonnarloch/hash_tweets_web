@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">Busca de Hashtags</div>
		<div class="panel-body">
			<form method="GET" action="search">
				<div class="form-group">
					<div class="col-sm-4">
						<label for="hashtag">#Hashtag#</label>
						<input type="text" name="hashtag" size="35">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<input type="submit" class="btn btn-primary btn-sm" value="Buscar">
					</div>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			//alert("Agora vai");
		});
	</script>
@endsection