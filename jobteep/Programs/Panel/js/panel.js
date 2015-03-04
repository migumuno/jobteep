/**
 * Se encarga de cargar el subsector de education correspondiente.
 */

function loadSubsector (str, foo, div) {
	var xmlhttp;

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById(div).innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","ajaxRequests.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+window.encodeURIComponent(str)+"&enum="+window.encodeURIComponent(foo)+"&action=subsector");
}

/**
 * Carga el contenido de un archivo en un div especificado.
 */
function loadFile(file, div) {
	var xmlhttp;
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    document.getElementById(div).innerHTML=xmlhttp.responseText;
	}
	xmlhttp.open("GET",file,true);
	xmlhttp.send();
}

/**
 * Busca coindicencias en la base de datos con lo introducido en el campo
 */

function showHint(str, foo, div) {
	if (str.length==0) { 
		document.getElementById(div).innerHTML="";
		return;
	}
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById(div).innerHTML=xmlhttp.responseText;
	    }
	}
	xmlhttp.open("GET","ajaxRequests.php?q="+str+"&action=find&enum="+foo,true);
	xmlhttp.send();
}

/**
 * Se ejecuta al autentificarse en Linkedin
 */

function onAuthLinkedin () {
	document.getElementById("modalLinkedin").innerHTML = 
		"<h2>Linkedin</h2><p class=\"lead\">Ya estás conectado/a! Ahora ya puedes importar tus datos.</p>";
}

/**
 * Obtiene todos los elementos de la API de Linkedin y los inserta en la BBDD.
 */

function instertData() {
	var auth = true;
  	function displayProfiles(profiles) {
  		var num_elements = 0;
      	profile = profiles.values[0];
      	
      	//TRABAJOS
		positions = profile.positions;
		positionCount = positions._total;
		var allpositions = new Array();
		for(var i = 0; i < positionCount; i++) {
			var company = positions.values[i].company.name.replace(/"/g, "");
			var title = positions.values[i].title.replace(/"/g, "");
			if (positions.values[i].startDate) {
				if (positions.values[i].startDate.month < 10)
					mes = "0" + positions.values[i].startDate.month;
				else
					mes = positions.values[i].startDate.month;
				var start = positions.values[i].startDate.year + "-" + mes + "-01";
			} else
				var start = "";
			if (positions.values[i].endDate) {
				if (positions.values[i].endDate.month < 10)
					mes_fin = "0" + positions.values[i].endDate.month;
				else
					mes_fin = positions.values[i].endDate.month;
				var end = positions.values[i].endDate.year + "-" + mes_fin + "-01";
			} else
				var end = "";
			if (positions.values[i].summary)
				var description = positions.values[i].summary.replace(/"/g, "&amp;quot;").replace(/'/g, "&amp;quot;");
			else
				var description = "";
			
			allpositions[i] = new Array(company, title, start, end, description);
		}
		var jsonPositions = JSON.stringify(allpositions);
		console.log(jsonPositions);
		
		//FORMACIÓN
		educations = profile.educations;
		educationCount = educations._total;
		var alleducations = new Array();
		for(var i = 0; i < educationCount; i++) {
			var titulation = educations.values[i].degree.replace(/"/g, "");
			var nameCenter = educations.values[i].schoolName.replace(/"/g, "");
			if (educations.values[i].startDate)
				var start = educations.values[i].startDate.year + "-01-01";
			else
				var start = "";
			if (educations.values[i].endDate)
				var end = educations.values[i].endDate.year + "-01-01";
			else
				var end = "";
			if (educations.values[i].notes)
				var description = educations.values[i].notes.replace(/"/g, "&amp;quot;").replace(/'/g, "&amp;quot;");
			else
				var description = "";
			
			alleducations[i] = new Array(titulation, nameCenter, start, end, description);
		}
		var jsonEducations = JSON.stringify(alleducations);
		
		//IDIOMAS
		languages = profile.languages;
		languageCount = languages._total;
		var alllanguages = new Array();
		for(var i = 0; i < languageCount; i++) {
			var name = languages.values[i].language.name.replace(/"/g, "");
			
			alllanguages[i] = new Array(name);
		}
		var jsonLanguages = JSON.stringify(alllanguages);
		
		//APTITUDES
		skills = profile.skills;
		skillCount = skills._total;
		var allskills = new Array();
		for(var i = 0; i < skillCount; i++) {
			var name = skills.values[i].skill.name.replace(/"/g, "");
			
			allskills[i] = new Array(name);
		}
		var jsonSkills = JSON.stringify(allskills);
		
		//PROYECTOS
		projects = profile.projects;
		projectCount = projects._total;
		var allprojects = new Array();
		for(var i = 0; i < projectCount; i++) {
			var name = projects.values[i].name.replace(/"/g, "");
			var description = projects.values[i].description.replace(/"/g, "&amp;quot;").replace(/'/g, "&amp;quot;");
			
			allprojects[i] = new Array(name, description);
		}
		var jsonProjects = JSON.stringify(allprojects);
		
		
		$.ajax({
            type: "POST",
            url: "ajaxRequests.php",
            async: false,
            data: { experience: jsonPositions, education: jsonEducations, language: jsonLanguages, skill: jsonSkills, proyect: jsonProjects, action : 'lnkdn'},
            success: function(data) {
            	num_elements++;
            	document.getElementById("importedElementsLinkedin").innerHTML = "<h1>" + num_elements + "</h1>";
            }
        });
		
		document.getElementById("importedLinkedin").innerHTML = "<h2>Todo importado!</h2><a href=\"http://www.jobteep.com/main.php?program=panel\" class=\"button\">CONTINUAR</a>";
	}
  	
  	function closeImported() {
  		$('#importedLinkedin').foundation('reveal', 'close');
  	}
  	
  	function displayConnections (connections) {
  		conn = connections.values[2];
		total = connections._total;
		name = conn.firstName + ' ' + conn.lastName;
		/*$.ajax({
            type: "POST",
            url: "ajaxRequests.php",
            data: {connections: total, enum: 'linkedin', action : 'lnkdn'},
            success: function(data) {
                document.getElementById("importedLinkedin").innerHTML = "<h2>Todo importado!</h2><a href=\"/main.php?program=panel\" class=\"button\">Continuar</a>";
            }
        });*/
		console.log(conn);
		console.log(name);
  	}
  	
  	function displayGroups(groupList) {
  		name = 'Grupo: ' + groupList.values[0].group.name;
  		console.log(groupList._total);
  		console.log(name);
  		console.log('Estado: ' + groupList.values[0].membershipState.code);
  		/*for (var i in groupList.values) {
  			groupList.values[i].group.name
  		}*/
  	}
  	
  	function displayUpdates (updatesList) {
  		
  	}
  	
  	try {
		/*IN.API.Profile("me").fields(["positions", "educations", "skills", "languages", "interests"]).result(displayProfiles);*/
		IN.API.Profile("me").fields(["positions", "educations", "skills", "languages", "projects"]).result(displayProfiles);
  		/*IN.API.Profile("me").result(displayProfiles);*/
		/*IN.API.Connections("me").result(displayConnections);
		IN.API.MemberUpdates("me").params({"type":"VIRL"}).result(displayUpdates);
		IN.API.Raw("people/~/group-memberships:(group:(id,name),membership-state)").result(displayGroups);*/
		$('#importedLinkedin').foundation('reveal', 'open');
  		/*$('#importedLinkedin').fadeIn( "slow" );*/
	} catch (err) {
		auth = false;
		document.getElementById("inventado").innerHTML = 
			"<h2>Error</h2><p class=\"lead\">"+err+"</p>";
		/*$('#modalLinkedin').foundation('reveal', 'open');*/
		$('#inventado').foundation('reveal', 'open');
	}
	if (!auth)
		$('#modalLinkedin').foundation('reveal', 'open');
}

/**
* Comprueba el estado de self para mostrar o no la formación y experiencia relacionada.
*/
function relacionados() {
	var select = document.getElementById("self").value;
	if (select == 0) {
		document.getElementById("relacionados").style.display = "block";
		document.getElementById("reason").style.display = "none";
	} else if (select = 1) {
		document.getElementById("relacionados").style.display = "none";
		document.getElementById("reason").style.display = "block";
	}
}

/**
* Comprueba el estado de self para mostrar o no la formación y experiencia relacionada.
*/
function explicate() {
	var select = document.getElementById("responsability").value;
	if (select == 0) {
		document.getElementById("responsabilities").style.display = "none";
		document.getElementById("knowledge").style.display = "none";
	} else if (select == 1) {
		document.getElementById("responsabilities").style.display = "block";
		document.getElementById("knowledge").style.display = "none";
	} else if (select == 2) {
		document.getElementById("responsabilities").style.display = "none";
		document.getElementById("knowledge").style.display = "block";
	}
}

/**
 * Muestra las opciones de destacados
 */
function typeDestacado() {
	var select = document.getElementById("typeDestacado").value;
	if (select == 0) {
		document.getElementById("img").style.display = "block";
		document.getElementById("video").style.display = "none";
	} else if (select == 1) {
		document.getElementById("img").style.display = "none";
		document.getElementById("video").style.display = "block";
	} 
}

/**
* Confirmar borrado de elementos
*/
function confirmDelete (pag, id, idproy) {
	var response = confirm("¿Estás seguro de que quieres eliminar el elemento?");
	if (idproy != null)
		proy = "&idproy="+idproy;
	else
		proy = '';
	if (response == true)
		window.location = "?program=panel&menu="+ pag + proy +"&action=deleteElement&id="+id;
}