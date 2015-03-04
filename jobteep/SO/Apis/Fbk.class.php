<?php
require_once 'Libraries/Facebook/src/facebook.php';

class Fbk {
	private $params;
	private $fbk_params;
	private $facebook;
	private $url;
	private $items;
	
	function Fbk() {
		$this->fbk_params = array(
			"intro" => array(
				"appId" => "778057912245850",
				"secret" => "d7611f04796ebfdbd815c7db1d7f5401"
			),
			"panel" => array(
				"appId" => "338661232969226",
				"secret" => "b3a538af2d645b64a0393a465f3eb3bd"
			)
		);
		$this->items = array(
			"book_reads" => "books.reads",
			"book_wants" => "books.wants_to_read",
			"likes" => "likes",
			"places" => "tagged_places",
			"fitness_runs" => "fitness.runs",
			"fitness_walks" => "fitness.walks",
			"fitness_bikes" => "fitness.bikes",
			"news_reads" => "news.reads",
			"news_publishes" => "news.publishes",
			"activities" => "activities",
			"interests" => "interests",
			"video_watches" => "video.watches",
			"video_wants" => "video.wants_to_watch",
			"num_friends" => "friends"
		);
	}
	
	public function getUrl () {
		return $this->url;
	}
	
	public function setParams ($api) {
		$this->params = $this->fbk_params[$api];
		$this->facebook = new Facebook($this->params);
		if ($api == "intro")
			$this->url = $this->facebook->getLoginUrl(array("redirect_uri" => "http://www.jobteep.com/main.php?program=panel&action=facebook",
					"scope" => "
						public_profile, 
						email, 
						user_birthday"
			));
		else if ($api == "panel")
			$this->url = $this->facebook->getLoginUrl(array("redirect_uri" => "http://www.jobteep.com/main.php?program=panel&action=facebook",
					"scope" => " 
						user_tagged_places,
						user_work_history,
						user_education_history,
						user_actions.books,
						user_actions.music,
						user_interests,
						user_likes,
						user_religion_politics,
						user_actions.fitness,
						user_about_me,
						user_actions.news,
						read_insights,
						user_relationships,
						user_events,
						user_status,
						user_website,
						user_activities,
						user_relationship_details,
						user_photos,
						user_hometown,
						publish_actions,
						read_friendlists,
						rsvp_event,
						user_location,
						user_actions.video,
						user_friends"
			));
	}
	
	public function getInfoUser () {
		$info = $this->facebook->api("/me");
		return $info;
	}
	
	public function getFriends () {
		return $this->facebook->api("/me/friends", "GET");
	}
	
	public function getItem ($item, $after = null) {
		/*$_SESSION['SO']->getUserInfo('facebook')*/
		/*if ($after != null) 
			return $this->facebook->api("/me/".$this->items[$item]."?limit=200&after=".$after, "GET");
		else
			return $this->facebook->api("/me/".$this->items[$item]."?limit=200", "GET");*/
		return $this->facebook->api("/me/".$this->items[$item]."?limit=200", "GET");
	}
	
	public function getIdUser () {
		return $this->facebook->getUser();
	}
}