<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>CSV Ninja</title>
    <link rel="stylesheet" href="mainStyle.css">
    <link rel="stylesheet" href="https://js.arcgis.com/3.19/esri/css/esri.css">
    <style type="text/css">
    #info{
    margin:4px auto;
    max-width:80%;
    color:#444;
    padding:0 10px
    }

    #tBar{
    margin:4px auto;
    max-width:80%;
    
    }
    map{

  height: 100%;
  width: 80%;
  margin: 0;
  padding: 0;
    }
    </style>
        <script src="https://js.arcgis.com/3.19/"></script>
    <script></script>
    <script>  
       var fields=[];
      var map;
      require([
        "dojo/dom",
        "dojo/on",
        "esri/map", 
        "esri/graphic",
        "esri/symbols/SimpleFillSymbol",
        "esri/symbols/SimpleLineSymbol", 
        "esri/Color",
        "esri/InfoTemplate", 
        "esri/layers/FeatureLayer",
        "esri/toolbars/draw",
        "esri/tasks/query",
        "dojo/domReady!"
      ], function(
        dom,
        on,
        Map,
        Graphic,
        SimpleFillSymbol, 
        SimpleLineSymbol,
        Color,
        InfoTemplate, 
        FeatureLayer,
        Draw,       
        Query,
        Ready    
      ) {
        map = new Map("map", {
          basemap: "streets",
          center: [133.25, -24.15],      
          zoom: 4
          });
        
     
        loading = dom.byId("loadingImg");
        
        on(map, "update-start", showLoading);
        on(map, "update-end", hideLoading);
        
        function showLoading() {
          esri.show(loading);
          //map.disableMapNavigation();
          map.hideZoomSlider();
        }

        function hideLoading(error) {
          esri.hide(loading);
          //map.enableMapNavigation();
          map.showZoomSlider();
        }

        var aus = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/0",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        }); 
        var ste = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/1",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sa4 = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/29",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sa3 = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/28",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sa2 = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/27",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sa1 = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/26",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var gssca = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/25",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var lga  = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/36",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sla = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/40",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var ssc = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/31",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var poa = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/30",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var ced = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/32",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sed = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/33",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sos  = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/41",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sosr  = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/42",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var ucl = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/43",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var sua  = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/44",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var ra  = new FeatureLayer("http://www.censusdata.abs.gov.au/arcgis/rest/services/TABLEBUILDER/MapServer/46",{
        mode: FeatureLayer.MODE_ONDEMAND,
        outFields: ["*"],
        });
        var currentSelection;
        var currentLayer;
        drawToolbar = new Draw(map);
        drawToolbar.on('draw-complete', function(e){
            
            drawToolbar.deactivate();
            var query = new Query();
            query.geometry = e.geometry;
            
            currentLayer.selectFeatures(query);
            currentSelection = query;

        });
        var selectionSymbol = new SimpleFillSymbol(
          SimpleFillSymbol.STYLE_SOLID, 
          new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID, 
          new Color([255,0,0]), 4), 
          new Color([255,0,0,0.6])
          );
        aus.setSelectionSymbol(selectionSymbol);
        ced.setSelectionSymbol(selectionSymbol);
        gssca.setSelectionSymbol(selectionSymbol);
        lga.setSelectionSymbol(selectionSymbol);
        poa.setSelectionSymbol(selectionSymbol);
        ra.setSelectionSymbol(selectionSymbol);
        sa1.setSelectionSymbol(selectionSymbol);
        sa2.setSelectionSymbol(selectionSymbol);
        sa3.setSelectionSymbol(selectionSymbol);
        sa4.setSelectionSymbol(selectionSymbol);
        sed.setSelectionSymbol(selectionSymbol);
        sla.setSelectionSymbol(selectionSymbol);
        sos.setSelectionSymbol(selectionSymbol);
        sosr.setSelectionSymbol(selectionSymbol);
        ssc.setSelectionSymbol(selectionSymbol);
        ste.setSelectionSymbol(selectionSymbol);
        sua.setSelectionSymbol(selectionSymbol);
        ucl.setSelectionSymbol(selectionSymbol);      
        map.addLayer(aus);
        map.addLayer(ste);
        map.addLayer(sa4);
        map.addLayer(sa3);
        map.addLayer(sa2);
        map.addLayer(sa1);
        map.addLayer(gssca);
        map.addLayer(lga);
        map.addLayer(sla);
        map.addLayer(ssc);
        map.addLayer(poa);
        map.addLayer(ced);
        map.addLayer(sed);
        map.addLayer(sos);
        map.addLayer(sosr);
        map.addLayer(ucl);
        map.addLayer(sua);
        map.addLayer(ra);
        //aus.hide();current
        currentLayer = aus;
        ste.hide();
        sa4.hide();
        sa3.hide();
        sa2.hide();
        sa1.hide();
        gssca.hide();
        lga.hide();
        sla.hide();
        ssc.hide();
        poa.hide();
        ced.hide();
        sed.hide();
        sos.hide();
        sosr.hide();
        ucl.hide();
        sua.hide();
        ra.hide();
        on(dom.byId('drawPolygon'), 'click', function() {
          clearSelectedAreas();
          drawToolbar.activate(Draw.POLYGON);
        });
        on(dom.byId('drawRectangle'), 'click', function() {
          clearSelectedAreas();
          drawToolbar.activate(Draw.RECTANGLE);
        });
        on(dom.byId('drawPoint'), 'click', function() {
          clearSelectedAreas();
          drawToolbar.activate(Draw.POINT);
        });

        on(dom.byId('sLayer'), 'change', function(e) {
          
          if(e.target.value === 999)
          {
            return 0;
          }
          var layer;
          var layerID
          for (var i = 0; i < map.graphicsLayerIds.length; i++) {  
              layerID = map.graphicsLayerIds[i];
              layer = map.getLayer(layerID);
              layer.setVisibility(false); 
              layer.clearSelection();

          }     
          layerID = map.graphicsLayerIds[e.target.value];
          layer = map.getLayer(layerID);
          layer.setVisibility(true);   
          currentLayer = layer; //applies visible layer to current layer for selection query.
          if(currentSelection != null){
            layer.selectFeatures(currentSelection); //passes the selection to the new layer.
            console.log("current selection was passed to the new layer");
          }
          // addData();  
        });

        on(dom.byId('Reset'), 'click', function() {
          drawToolbar.deactivate();
          clearSelectedAreas();          
        
        });


        on(dom.byId('getData'), 'click', function() {
          fields.length=0;
          var layer = currentLayer;
          selection = layer.getSelectedFeatures();
          var code;
          //get the attributes for the first Object in the selected graphics
          //then search it for its CODE element. Take substring search result.
          //then build an array of all of those codes from the selected features.
          var layer;
          var layerID
          for (var i = 0; i < map.graphicsLayerIds.length; i++) {  
              layerID = map.graphicsLayerIds[i];
              layer = map.getLayer(layerID);
              //console.log("this layer is number" + i + "and it is visible?" + layer.visible); 
              if(layer.visible)
              {
                layerNum = i;
              }

          } 
          code = getLayerAttributesGIS(layerNum);
          fields.push(code);
          for(var i = 0; i < selection.length && i < 1000; i++)
          {
            value = selection[i].attributes[code];
            fields.push(value);

          }
          document.getElementById("fieldsArr").value = fields;
      
        });
        
        function getLayerAttributesGIS(layerNum){
          var code;
          switch (layerNum) {
                  case 0: 
                  code = "AUST_CODE";
                  break;

                  case 1: 
                  code = "STE_CODE";
                  break;
                
                  case 2: 
                  code = "SA4_CODE";
                  break; 

                  case 3: 
                  code = "SA3_CODE";
                  break; 

                  case 4: 
                  code = "SA2_MAIN";
                  break; 

                  case 5: 
                  code = "SA1_7DIGIT";
                  break; 

                  case 6: 
                  code = "CGGSA_CODE";
                  break; 

                  case 7: 
                  code = "LGA_CODE";
                  break; 

                  case 8: 
                  code = "SLA_MAIN";
                  break; 

                  case 9: 
                  code = "SSC_CODE";
                  break; 

                  case 10: 
                  code = "POA_CODE";
                  break; 

                  case 11: 
                  code = "CED_CODE";
                  break; 

                  case 12: 
                  code = "SED_CODE";
                  break; 

                  case 13: 
                  code = "SOS_CODE";
                  break; 

                  case 14: 
                  code = "SOSR_CODE";
                  break; 

                  case 15: 
                  code = "UCL_CODE";
                  break; 

                  case 16: 
                  code = "SUA_CODE";
                  break; 

                  case 17: 
                  code = "RA_CODE";
                  break; 
                }
                return code;
        };

        function clearSelectedAreas(){
          var layer;
          var layerID
          for (var i = 0; i < map.graphicsLayerIds.length; i++) {  
              layerID = map.graphicsLayerIds[i];
              layer = map.getLayer(layerID);
              layer.clearSelection();
          } 
        }

  

      });
    </script>
</head>
<body>  
<div id="tBar"><?php require("title.php");?></div>
<div id="info" style="height:95%">


          <div id="control"> 
           <a class="button" href="#popup1"><input type="button" value="Select Fields"/></a>
          <select id="sLayer" name="sLayer">
              <option value="0" selected="selected">Australia</option>
              <option value="1">State/Territory</option>
              <option value="2">Statistical Area Level 4</option>
              <option value="3">Statistical Area Level 3</option>
              <option value="4">Statistical Area Level 2</option>
              <option value="5">Statistical Area Level 1</option>
              <option value="6">Greater Capital City Statistical Areas</option>
              <option value="7">Local Government Areas</option>
              <option value="8">Statistical Local Areas</option>
              <option value="9">State Suburbs</option>
              <option value="10">Postal Areas</option>
              <option value="11">Commonwealth Electoral Divisions</option>
              <option value="12">State Electoral Divisions</option>
              <option value="13">Section of State</option>
              <option value="14">Section of State Ranges</option>
              <option value="15">Urban Centres and Localities</option>
              <option value="16">Significant Urban Areas</option>
              <option value="17">Remoteness Areas</option>
          </select> 
        
          <input name="drawPolygon" type="button" id="drawPolygon" value="Select Polygon"/>
          <input name="drawRectangle" type="button" id="drawRectangle" value="Select Rectangle"/>
          <input name="drawPoint" type="button" id="drawPoint" value="Select Point"/>
          <input name="Reset" type="button" id="Reset" value="Reset"/>
   
           <form id="fieldForm" action="genCSV.php" method="post" style='display:inline;'>
           <input name="getData" type="submit" id="getData" value="Get Data"/>
            <input type="hidden" id="fieldsArr" name="fieldsArr" value=""/>
           </div>             
      
      <div id="map" style="height:90%;">
        <div id="frame"> <img id="loadingImg" src="img/loading.gif"/></div>
      </div>  
      
        <div id="popup1" class="overlay">
        <div class="popup">
          <div style="width:80%; " >
          <h4>Select fields  from this dataset from the options below. Hold <i>Control</i> to select more than one field.<br><br>
          Note: After you have made your selection <b>Just hit close, you <u>won't</u> lose your selection and you can change it at any time</b>all you need to do is hit the "Get Data" Button and you'll be taken to a new window with data!
          Hit the X to close this window and go back to the map<br></h4></div>
          <div  style="margin-left: 80%; overflow:hidden; padding: 10px;">
          <a class="close" href="#">Close X</a>
          </div>
          <div class="clear"></div>
          <div class="content">
          <?php require("selectionList.php");?>
        </form>
        </div>
      </div>
      








</div>
</html>
