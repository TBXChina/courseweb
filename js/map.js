
  //map, main body
  var map = new AMap.Map('container' ,{
      zoom: 17,
      center: [118.9615169379,32.1108455072] //Panzhonglai Building Longitude and Latitude
  });

  var marker = new AMap.Marker({
      position: [118.9615169379,32.1108455072],
      map: map
  });


  //Scale Rule
  AMap.plugin(['AMap.ToolBar', 'AMap.Scale'], function(){
      var toolBar = new AMap.ToolBar();
      var scale = new AMap.Scale();
      map.addControl(toolBar);
      map.addControl(scale);
  });
  
