@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<form class="form-inline" method="GET" action="{{ action('TwitterController@history') }}">
				<div class="form-group col-md-offset-4">
					<input type="text" class="form-control" name="hashtag" value="{{ $hashtag }}" placeholder="#Hashtag" size="32">
				</div>
				<input type="submit" class="btn btn-primary btn-sm" value="Buscar">
			</form>
		</div>

		<div class="panel-body">
			@if (empty($hashtagHistory) && !empty($hashtag))
				<div class="alert alert-danger">
					<ul>
						Hashtag não encontrada.
					</ul>
				</div>
			@endif

			@foreach ($hashtagHistory as $history)
				<div class="alert alert-info" role="alert">	
					<div class="row">
						<div class="col-sm-5"><b>{{ $history['created_at'] }}</b></div>
						<div class="col-sm-5"><b>{{ ($history['tweet_count'] == 1) ? $history['tweet_count'] . ' TWEET' : $history['tweet_count'] . ' TWEETS' }}</b></div>
					</div>
				</div>
				@include('twitter._hashtaginfo', ['topTweets' => $history['top_retweets']])
			@endforeach
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			$("#menu_history").addClass("active");
		});
	</script>
@endsection