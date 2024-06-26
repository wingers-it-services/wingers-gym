(function ($) {
    "use strict"


/*******************
jQvectormap
*******************/

    $('#world-map').vectorMap({ 
        map: 'world_en',
        backgroundColor: 'transparent',
        borderColor: 'rgb(239, 242, 244)',
        borderOpacity: 0.25,
        borderWidth: 1,
        color: 'rgb(239, 242, 244)',
        enableZoom: true,
        hoverColor: 'rgba(110, 197, 30, 0.9)',
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: 'rgba(110, 197, 30, 0.9)',
        selectedRegions: null,
        showTooltip: true,
        onRegionClick: function(element, code, region)
        {
            var message = 'You clicked "'
                + region
                + '" which has the code: '
                + code.toUpperCase();
     
            alert(message);
        }
    });

    $('#usa').vectorMap({ 
        map: 'usa_en',
        backgroundColor: 'transparent',
        borderColor: 'rgb(239, 242, 244)',
        borderOpacity: 0.25,
        borderWidth: 1,
        color: 'rgb(239, 242, 244)',
        enableZoom: true,
        hoverColor: 'rgba(110, 197, 30, 0.9)',
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: 'rgba(110, 197, 30, 0.9)',
        selectedRegions: null,
        showTooltip: true,
        onRegionClick: function(element, code, region)
        {
            var message = 'You clicked "'
                + region
                + '" which has the code: '
                + code.toUpperCase();
     
            alert(message);
        }
    });
})(jQuery);