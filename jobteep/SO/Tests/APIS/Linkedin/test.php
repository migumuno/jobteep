<html>
<head>
<title>LinkedIn JavaScript API Hello World</title>

<!-- 1. Include the LinkedIn JavaScript API and define a onLoad callback function -->
<script type="text/javascript" src="https://platform.linkedin.com/in.js">
  api_key: 77i0wrm327h22q
  onLoad: onLinkedInLoad
  authorize: true
</script>

<script type="text/javascript">
  // 2. Runs when the JavaScript framework is loaded
  function onLinkedInLoad() {
    IN.Event.on(IN, "auth", onLinkedInAuth);
  }

  // 2. Runs when the viewer has authenticated
  function onLinkedInAuth() {
    IN.API.Profile("me").result(displayProfiles);
  }

  // 2. Runs when the Profile() API call returns successfully
  function displayProfiles(profiles) {
    member = profiles.values[0];
    document.getElementById("profiles").innerHTML = 
      "<p id=\"" + member.id + "\">Hello " +  member.firstName + " " + member.lastName + "</p>";
  }
</script>
</head>
<body>
<!-- 3. Displays a button to let the viewer authenticate -->
<script type="IN/Login"></script>

<!-- 4. Placeholder for the greeting -->
<div id="profiles"></div>

</body>
</html>