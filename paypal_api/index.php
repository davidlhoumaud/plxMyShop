<?php header("Location : http://".$_SERVER['HTTP_HOST']); ?>
<html>
<head>
<title>plxMyShop</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="0; URL=http://<?php echo $_SERVER['HTTP_HOST']; ?>">
</head>
<body bgcolor="#FFFFFF" text="#222" align="center">
Redirection vers <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>"><?php echo $_SERVER['HTTP_HOST']; ?></a> en cours...
<script type="text/javascript" language="JavaScript">
    window.location.href="http://<?php echo $_SERVER['HTTP_HOST']; ?>"
</script>
</body>
</html>
