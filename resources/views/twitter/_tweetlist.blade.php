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
				- {{ TweetInfo::displayDateTime($tweet->created_at) }}
			</span>

			<div class="tweet-text js-tweet-text tweet">
				<p>
					{{ $tweet->text }}
				</p>
			</div>

			<div class="tweet-media text-center">
				@if (isset($tweet->extended_entities->media))
					@foreach ($tweet->extended_entities->media as $key => $media)
						@if ($media->type == 'video' || $media->type == 'animated_gif')
							<video class="tweet-video" width="510" height="auto" controls>
								<source src="{{ $media->video_info->variants[0]->url }}" type="{{ $media->video_info->variants[0]->content_type }}">
								Este navegador não suporta a visualização de vídeos.
							</video>
						@else
							@if ($key == 0)
								@if (count($tweet->extended_entities->media) > 1)
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
					{{ $tweet->retweet_count }}
				</span>
				<span class="glyphicon glyphicon-heart-empty tweet-profile">
					{{ $tweet->favorite_count }}
				</span>
			</div>
		</div>
	</div>
	<hr>
@endforeach