// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
var options={
    //types:['(cities)'],
    componentRestrictions: { country: "TW" },
    fields: ["place_id"],
  }

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
      mapTypeControl: false,
      center: { lat: 24.787135629341424 ,lng:  120.99757049164103 },
      zoom: 13,
    });

    new AutocompleteDirectionsHandler(map);
  }
  
  class AutocompleteDirectionsHandler {
    map;
    originPlaceId;
    destinationPlaceId;
    travelMode;
    directionsService;
    directionsRenderer;

    constructor(map) {
      this.map = map;
      this.originPlaceId = "";
      this.destinationPlaceId = "";
      this.travelMode = google.maps.TravelMode.WALKING;
      this.directionsService = new google.maps.DirectionsService();
      this.directionsRenderer = new google.maps.DirectionsRenderer();
      this.directionsRenderer.setMap(map);
  
      const originInput = document.getElementById("origin-input");
      const destinationInput = document.getElementById("destination-input");
      const modeSelector = document.getElementById("mode-selector");
      const originAutocomplete = new google.maps.places.Autocomplete(originInput,options);
      const destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput,options);
      const myplace=document.getElementById("origin-input");
      
      
     
      this.setupClickListener(
        "changemode-walking",
        google.maps.TravelMode.WALKING
      );
      this.setupClickListener(
        "changemode-transit",
        google.maps.TravelMode.TRANSIT
      );
      this.setupClickListener(
        "changemode-driving",
        google.maps.TravelMode.DRIVING
      );
      
      this.setupPlaceChangedListener(originAutocomplete, "ORIG");
      this.setupPlaceChangedListener(destinationAutocomplete, "DEST");
      
      this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
      this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
      this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
     

      const locationButton = document.createElement("button");
      locationButton.textContent = "use your location"; 
      locationButton.classList.add("custom-map-control-button");
      this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(locationButton);
      // origin-input -> myplace -> myposition
      this.changetomylocation(locationButton,myplace); 
    }
    
    // Sets a listener on a radio button to change the filter type on Places
    // Autocomplete.
    setupClickListener(id, mode) {
      const radioButton = document.getElementById(id);
  
      radioButton.addEventListener("click", () => {
        this.travelMode = mode;
        this.route();
      });
    }
    

    

     

    changetomylocation(button,myposition){
      button.addEventListener("click", () => {
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            (position) => {
              const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
              };
              const output2=document.querySelector('#output2');
              console.log(pos.lat);
              

              // var lati =  24.787135629341424;
              // var longi = 120.99757049164103
              var naviPlaceID = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + pos.lat + "," + pos.lng +"&key=AIzaSyCaPmpoPpEpG1rumCf8G35oKI9NVdMNH8s";
              var request = new XMLHttpRequest();
              request.open('GET', naviPlaceID);
             
              request.onload = function() {
                  //console.log(request.readyState);
                  var data = JSON.parse(this.responseText);
                  this.originPlaceId = data.results[0].place_id;
                  myposition=data.results[0];
                  console.log( "why can't i?   ori:  "+ myposition.place_id);
                
              }
              //request.send();
              request.send();
              console.log("two");
              this.originPlaceId = myposition.place_id;
              myposition.value="myposition";
              console.log(this.originPlaceId);
              this.route();
            },
            () => {
              //handleLocationError(true, infoWindow, map2.getCenter());
              
            }
          );
        } 
        else {
        }
       
         
      });
      // console.log("one");
      // this.route();
    }
    setupPlaceChangedListener(autocomplete, mode) {
      autocomplete.bindTo("bounds", this.map);
      autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
  
        if (!place.place_id) {
          window.alert("Please select an option from the dropdown list.");
          return;
        }
        if (mode === "ORIG") {
          this.originPlaceId = place.place_id;
          console.log("three");
        } else if (mode === "DEST"){
          this.destinationPlaceId = place.place_id;
          console.log("four");
        }
  
        this.route();
      });
    }
    
    route() {
      if (!this.originPlaceId || !this.destinationPlaceId) {
        console.log("ori1:");
        console.log(this.originPlaceId);
        console.log("dest1:");
        console.log(this.destinationPlaceId);
        return;
      }
      
      const me = this;
      
        this.directionsService.route(
          {
            origin: { placeId: this.originPlaceId },
            destination: { placeId: this.destinationPlaceId },
            travelMode: this.travelMode,
          },
          (response, status) => {
            if (status === "OK" ) {
             // console.log("ori2:");
              console.log(this.originPlaceId);
              //console.log("dest2:");
              console.log(this.destinationPlaceId);

              const output=document.querySelector('#output');
              output.innerHTML="<div class='alert-info'>From:"+document.getElementById("origin-input").value+".<br/>To:"+document.getElementById("destination-input").value+".<br/>DISTANCE :"+ response.routes[0].legs[0].distance.text+"<br/>DURATION :"+response.routes[0].legs[0].duration.text+"</div>";
              me.directionsRenderer.setDirections(response);
            } else {
              window.alert("Directions request failed due to " + status);
            }
          }
        );
      }
      
    }
  