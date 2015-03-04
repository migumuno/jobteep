<?php
include_once 'Model/Collection.class.php';

include_once 'Model/Elements/Content/Entity/Activity.class.php';
include_once 'Model/Elements/Content/Entity/Article.class.php';
include_once 'Model/Elements/Content/Entity/Blog.class.php';
include_once 'Model/Elements/Content/Entity/Education.class.php';
include_once 'Model/Elements/Content/Entity/Experience.class.php';
include_once 'Model/Elements/Content/Entity/Forum.class.php';
include_once 'Model/Elements/Content/Entity/Info.class.php';
include_once 'Model/Elements/Content/Entity/Language.class.php';
include_once 'Model/Elements/Content/Entity/Settings.class.php';
include_once 'Model/Elements/Content/Entity/Proyect.class.php';
include_once 'Model/Elements/Content/Entity/ProyectImg.class.php';
include_once 'Model/Elements/Content/Entity/Skill.class.php';
include_once 'Model/Elements/Content/Entity/Travel.class.php';
include_once 'Model/Elements/Content/Entity/User.class.php';
include_once 'Model/Elements/Content/Entity/Upgrade.class.php';
include_once 'Model/Elements/Content/Entity/MTLCulture.class.php';
include_once 'Model/Elements/Content/Entity/MTLArt.class.php';
include_once 'Model/Elements/Content/Entity/MTLSport.class.php';
include_once 'Model/Elements/Content/Entity/MTLGeek.class.php';
include_once 'Model/Elements/Content/Relation/ActivityLanguage.class.php';
include_once 'Model/Elements/Content/Relation/ActivitySkill.class.php';
include_once 'Model/Elements/Content/Relation/ActivityTravel.class.php';
include_once 'Model/Elements/Content/Relation/EducationLanguage.class.php';
include_once 'Model/Elements/Content/Relation/EducationSkill.class.php';
include_once 'Model/Elements/Content/Relation/EducationTravel.class.php';
include_once 'Model/Elements/Content/Relation/ExperienceLanguage.class.php';
include_once 'Model/Elements/Content/Relation/ExperienceSkill.class.php';
include_once 'Model/Elements/Content/Relation/ExperienceTravel.class.php';
include_once 'Model/Elements/Content/Relation/ProyectLanguage.class.php';
include_once 'Model/Elements/Content/Relation/ProyectSkill.class.php';
include_once 'Model/Elements/Content/Relation/ProyectTravel.class.php';
include_once 'Model/Elements/Content/Relation/TravelLanguage.class.php';
include_once 'Model/Elements/Content/Templates/Origin.class.php';

class ElementParser {
	private $collection;
	
	function ElementParser() {
		$this->collection = new Collection();
		$this->collection->addItem(new Activity(), "activity");
		$this->collection->addItem(new Article(), "article");
		$this->collection->addItem(new Blog(), "blog");
		$this->collection->addItem(new Education(), "education");
		$this->collection->addItem(new Experience(), "experience");
		$this->collection->addItem(new Forum(), "forum");
		$this->collection->addItem(new Info(), "info");
		$this->collection->addItem(new Language(), "language");
		$this->collection->addItem(new Settings(), "settings");
		$this->collection->addItem(new Proyect(), "proyect");
		$this->collection->addItem(new ProyectImg(), "proyectimg");
		$this->collection->addItem(new Skill(), "skill");
		$this->collection->addItem(new Travel(), "travel");
		$this->collection->addItem(new User(), "user");
		$this->collection->addItem(new Upgrade(), "upgrade");
		$this->collection->addItem(new MTLCulture(), "mtlculture");
		$this->collection->addItem(new MTLArt(), "mtlart");
		$this->collection->addItem(new MTLSport(), "mtlsport");
		$this->collection->addItem(new MTLGeek(), "mtlgeek");
		$this->collection->addItem(new ActivityLanguage(), "activitylanguage");
		$this->collection->addItem(new ActivitySkill(), "activityskill");
		$this->collection->addItem(new ActivityTravel(), "activitytravel");
		$this->collection->addItem(new EducationLanguage(), "educationlanguage");
		$this->collection->addItem(new EducationSkill(), "educationskill");
		$this->collection->addItem(new EducationTravel(), "educationtravel");
		$this->collection->addItem(new ExperienceLanguage(), "experiencelanguage");
		$this->collection->addItem(new ExperienceSkill(), "experienceskill");
		$this->collection->addItem(new ExperienceTravel(), "experiencetravel");
		$this->collection->addItem(new ProyectLanguage(), "proyectlanguage");
		$this->collection->addItem(new ProyectSkill(), "proyectskill");
		$this->collection->addItem(new ProyectTravel(), "proyecttravel");
		$this->collection->addItem(new TravelLanguage(), "travellanguage");
		$this->collection->addItem(new Origin(), "origin");
	}
	
	public function parser ($key) {
		try {
			$obj = clone $this->collection->getItem($key);
			$obj->setUser($_SESSION['SO']->getUID());
			return $obj;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>