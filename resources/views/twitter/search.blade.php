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

		@if (!empty($hashtag))
			<div class="panel-body">
				<div class="row">
					<div class="alert alert-success col-md-2 col-md-offset-5 text-center" role="alert">
					  <h3>{{ $countTweets }}</h3>
					  <h4 class="alert-heading">{{ ($countTweets == 1) ? 'TWEET' : 'TWEETS' }}</h4>
					</div>
				</div>
				
				<div class="row">
					<div class="alert alert-info text-center" role="alert">					
						TOP {{ $numTopRetweets }} - Mais Retweetados
					</div>
				</div>

				@foreach ($topTweets as $tweet)
					<div class="row">
						<div class="col-md-1 col-md-offset-2">
							<img class="avatar" src="{{ $tweet->user->profile_image_url }}">
						</div>

						<div class="col-md-6">
							<span class="fullname">
								{{ $tweet->user->name }}
							</span>
							<span class="username">
								{{ '@' . $tweet->user->screen_name }}
							</span>
							<span class="tweet time">
								- {{ TweetInfo::displayDateTime($tweet->retweeted_status->created_at) }}
							</span>

							<div class="tweet-text js-tweet-text tweet">
								<p>
									{{ $tweet->retweeted_status->text }}
								</p>
							</div>

							<div class="tweet-media text-center">
								@if (isset($tweet->retweeted_status->extended_entities->media))
									@foreach ($tweet->retweeted_status->extended_entities->media as $key => $media)
										@if ($media->type == 'video' || $media->type == 'animated_gif')
											<video class="tweet-video" width="510" height="auto" controls>
												<source src="{{ $media->video_info->variants[0]->url }}" type="{{ $media->video_info->variants[0]->content_type }}">
												Este navegador não suporta a visualização de vídeos.
											</video>
										@else
											@if ($key == 0)
												@if (count($tweet->retweeted_status->extended_entities->media) > 1)
													<div class="left">
														<img class="img-fluid" src="{{ $media->media_url }}" height="330" width="400">
													</div>
												@else
													<div>
														<img class="img-fluid tweet-img-main" src="{{ $media->media_url }}" height="330" width="auto">
													</div>
												@endif
											@else
												<div class="left">
													<img class="img-fluid" src="{{ $media->media_url }}" height="110" width="110">
												</div>
											@endif
										@endif
									@endforeach
								@endif
							</div>

							<div class="tweet-info left">
								<span class="glyphicon glyphicon-retweet tweet-profile">
									{{ $tweet->retweeted_status->retweet_count }}
								</span>
								<span class="glyphicon glyphicon-heart-empty tweet-profile">
									{{ $tweet->retweeted_status->favorite_count }}
								</span>
							</div>
						</div>
					</div>
					<hr>
				@endforeach
			</div>
		@endif
	</div>

	<script type="text/javascript">
		$(function() {
			$("#menu_search").addClass("active");
		});
	</script>
@endsection