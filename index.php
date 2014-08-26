<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="Visualization of Civic Hacking Community">
	<meta name="keywords" content="Microsoft, Civic, Technology">
	<meta name="author" content="Civic Technology Fellows">
    
	<title>Civic Technology Visualization</title>

	<!--[if lt IE 9]>
		<script src="html5shiv-master/src/html5shiv.js"></script>
	<![endif]-->
	<!--[if IE]>
		<script type="text/javascript" src="stylesheets/PIE-1.0.0/PIE.js"></script>
	<![endif]-->
	<link type="text/css" rel="shortcut icon" href="images/microsoft.ico"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/reset.css"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/normalize.css"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/Metro-UI-CSS-master/css/metro-bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/Metro-UI-CSS-master/css/metro-bootstrap-responsive.css"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/font-awesome/css/font-awesome.min.css"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/style.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/herograph.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/checkboxes.css"/>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>
    <script type="text/javascript" src="stylesheets/Metro-UI-CSS-master/min/jquery.min.js"></script>
    <script type="text/javascript" src="stylesheets/Metro-UI-CSS-master/min/jquery.widget.min.js"></script>
    <script type="text/javascript" src="stylesheets/Metro-UI-CSS-master/min/metro.min.js"></script>
    <script type="text/javascript" src="scripts/aight-master/aight.js"/>
	<script type="text/javascript" src="scripts/modernizr-latest.js"></script>
	<script type="text/javascript" src="scripts/d3.v3.min.js"></script>
	<!-- <script> aight.browser.ie8 = true; </script> -->
	<script type="text/javascript" src="scripts/aight-master/aight.d3.js"></script>
</head>
<body class="metro">
	<!---Microsoft Nav Bar-->
	<nav class="navigation-bar dark fixed-top shadow">
	  	<nav class="navigation-bar-content">
	  		<div class="navstyle">
				<div><a id="website-name" href="JavaScript: location.reload(true);"><span class="large">ATHENA</span> <span class="small">Civic Insights</span></a></div>
			</div>
			
			<!-- Upload File -->
			<!-- <div class="input-control file" data-role="input-control">
				<input type="file" style="z-index: 0;" tabindex="-1"></input>
				<input id="__input_file_wrapper__" type="text" style="z-index:1; cursor:default;" readonly=""></input>
				<button class="btn-file" type="button"></button>  
			</div> -->
			<a href="http://www.microsoft.com/en-us/default.aspx" target="_blank"><img src="images/ms_logo.png" id="logo" align="right" height="200" width="120"></a>
	   	</nav>
	</nav>
	<div id="wrapper">
		<!-- Sidebar Content -->
		<nav class="main-nav" id="main-nav">

				<div>
					<div class="filter-name-location input-control text">
					    <input id="search-text" type="text" placeholder="Filter by name or location" list="data-name-location"/>
					    <datalist id='data-name-location'>
					    </datalist>
					</div>
				</div>
			<!-- Entities -->
				<div class="group-items types">
					<div>
						<label>
							<div class = "typestext"><strong><h3>Types</h3></strong></div>
						</label>
						<div class="input-control checkbox" data-role="input-control">	
							<label>
								<input type="checkbox" name="forprofit" data-show="for-profit" id="cb_forpro" value="For-Profit" checked/>
								<span class="check"></span><h4>For-Profit</h4>
							</label>
						</div>
						<div class="input-control checkbox" data-role="input-control">	
							<label>
								<input type="checkbox" name="nonprofit" data-show="non-profit" id="cb_nonpro" value="Non-Profit" checked/>
								<span class="check"></span><h4>Non-Profit</h4>
							</label>
						</div>


						<div class="input-control checkbox" data-role="input-control">		
							 <label>
							 	<input type="checkbox" name="government" data-show="government" id="cb_gov" value="Government" checked/>
							 	<span class="check"></span><h4>Government</h4>
							 </label>
						</div>
						<div class="input-control checkbox" data-role="input-control">
						    <label>
						    	<input type="checkbox" name="individual" data-show="individual" id="cb_individ" value="Individual" checked/>
						    	<span class="check"></span><h4>Individual</h4>
						    </label>
						</div>
					</div>
				</div>
				<!-- Connections -->
				<div class="group-items connections">
					<div>
						<label>
							<div class="connectionstext"><strong><h3>Connections</h3></strong><br></strong></div>
						</label>
						<div class="input-control checkbox" data-role="input-control">	
							<label>
								<input type="checkbox" name="invest" data-show="investing" id="cb_invest" value="Investing" checked/>
								<span class="check"></span><h4>Investing</h4>
							</label>
						</div>
						<div class="input-control checkbox" data-role="input-control">
					    	<label>
					    		<input type="checkbox" name="fund" data-show="funding" id="cb_fund" value="Funding" checked/>
					    		<span class="check"></span><h4>Funding</h4>
					    	</label>
						</div>
						
						<div class="input-control checkbox" data-role="input-control">	
							<label>
								<input type="checkbox" name="poruc" data-show="poruc" id="cb_porucs" value="Poruc" checked/>
								<span class="check"></span><h4>Collaboration</h4>
							</label>
						</div>
						<div class="input-control checkbox" data-role="input-control">		
							<label>
							 	<input type="checkbox" name="affil" data-show="affil" id="cb_affil" value="Affiliations" checked/>
							 	<span class="check"></span><h4>Affiliation</h4>
							 </label>
						</div>
					</div>
				</div>
				
				<!-- Relevance -->
				<div class="group-items relevance">
					<div>
						<label>
							<div class="sized_bytext"><strong><h3>Sized By</h3></strong></div>
						</label>
						<div class="input-control radio default-style" data-role="input-control">
						    <label>
						    	<input type="radio" name="relevance" id="cb_emp" value="Employees" checked/>
						    	<span class="check"></span><h4>Employees</h4>
						    </label>
						</div>
						<!-- <div class="input-control radio default-style" data-role="input-control">	
							<label>
								<input type="radio" name="relevance" id="cb_budget" value="Budgeting"/>
								<span class="check"></span>Budget ($)<i class="rel-icon fa fa-money fa-fw"></i>
							</label>
						</div> -->
						<div class="input-control radio default-style" data-role="input-control">	
							<label>
								<input type="radio" name="relevance" id="cb_numtwit" value="Followers"/>
								<span class="check"></span><h4>Twitter</h4>
							</label>
						</div>
					</div>
				</div>
				

		  
		</nav>
		<div class="page-wrap">
			<div class="content">
		    	<!-- <svg id="chart">
					<defs>
				    <marker id="Triangle"
				    	viewBox="0 0 10 10"
					    refX="1" refY="5" 
					    markerUnits="strokeWidth"
					    markerWidth="6" markerHeight="6"
				        orient="auto">
					    <path d="M 0 0 L 10 5 L 0 10 z" />
					</marker>
					<marker id="Circle" markerWidth="8" markerHeight="8" refx="5" refy="5">
		        		<circle cx="5" cy="5" r="3" style="stroke: none; fill:#000000;"/>
		    		</marker>

					</defs>
				</svg> -->
  			</div>


			<div class="example">
				<div id="info"></div>
			</div>

			<!-- <label for="main-nav-check" class="toggle-menu">
				<div class="arrow" id="arrowImage"></div>
			</label>  -->

  			
		</div>
	</div>
	<!-- div id="random">

	</div> -->
	
	<!--<script type="text/javascript" src="scripts/conversion.js"></script>-->
	
	<?php
		// include "appendLinks.php";
	?>
	
	
	<script type="text/javascript" src="scripts/underscore-min.js"></script>
	<script type="text/javascript" src="scripts/graph.js"></script>
</body>
</html>