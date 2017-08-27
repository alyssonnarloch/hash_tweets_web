@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<form class="form-inline" method="GET" action="search">
				<div class="form-group col-md-offset-4">
					<input type="text" class="form-control" name="hashtag" value="{{ $hashtag }}" placeholder="#Hashtag" size="32">
				</div>
				<input type="submit" class="btn btn-primary btn-sm" value="Buscar">
			</form>
		</div>

		<div class="panel-body">
			@if (!empty($hashtag))
				<div class="row">
					<div class="alert alert-success col-md-2 col-md-offset-5 text-center" role="alert">
					  <h3>{{ $tweetCount }}</h3>
					  <h4 class="alert-heading">{{ ($tweetCount == 1) ? 'TWEET' : 'TWEETS' }}</h4>
					</div>
				</div>

				<div class="row">
					<div class="alert alert-info text-center" role="alert">					
						TOP {{ $numTopRetweets }} - Mais Retweetados
					</div>
				</div>
				@include('twitter._hashtaginfo', ['topTweets' => $topTweets])
			@endif
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			$("#menu_search").addClass("active");
		});
	</script>
@endsection