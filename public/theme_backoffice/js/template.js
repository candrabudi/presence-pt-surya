/*
* Admin Layout (timetracker)
* @requires:jquery: 3.6.0 or later
* @author: Pixelwibes
* @design by: Pixelwibes.
* @event-namespace:timetracker
* Copyright 2022 Pixelwibes
*/

if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function() {
    "use strict";

    // main sidebar toggle js
    $('.menu-toggle').on('click', function () {
        $('.sidebar').toggleClass('open');
        $('.open').removeClass('sidebar-mini');
    });

    $('.menu-toggle-option').on('click', function () {
        $('.menu').toggleClass('open');
    });

    $('.body').on('click', function() {
        $('.sidebar').removeClass('open');
    });
    
    // layout a sidebar mini version
    $('.sidebar-mini-btn').on('click', function () {
        $('.sidebar').toggleClass('sidebar-mini');
        $('.sidebar-mini').removeClass('open');
    });

    // chat page chatlist toggle js
    $('.chatlist-toggle').on('click', function () {
        $('.card-chat').toggleClass('open');
    });

    // LTR/RTL active js
    $(".theme-rtl input").on('change',function() {
        if(this.checked) {
            $("body").addClass('rtl_mode');
        }else{
            $("body").removeClass('rtl_mode');
        }
       
    });

    // search result div show/hide
    $(".main-search input").on("focus",function(){
        $('.search-result').addClass("show");
    });
    $(".main-search input").on("blur",function(){
        $('.search-result').removeClass("show");
    });

     // google font setting
     $('.font_setting input:radio').on('click', function ()  {
		var others = $("[name='" + this.name + "']").map(function () {
			return this.value
		}).get().join(" ")
		console.log(others)
		$('body').removeClass(others).addClass(this.value)
    });

    // cSidebar overflow daynamic height
    
    overFlowDynamic();

    $(window).resize(function(){
        overFlowDynamic();
    });

    function overFlowDynamic(){ 
        var sideheight=$(".sidebar.sidebar-mini").height() + 48;
        
        if(sideheight <= 760) {  
            $(".sidebar.sidebar-mini").css( "overflow", "scroll");  
        }
        else{
            $(".sidebar.sidebar-mini").css( "overflow", "visible"); 
        }
    }

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    //Dropdown scroll hide using table responsive
    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
    });
   
    $('.table-responsive').on('hide.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "auto" );
    })
});

// theme color setting
$(function() {
    "use strict";
    let root = document.documentElement;
    $('.choose-skin li').on('click', function() {
        var $body = $('#timetracker-layout');
        var $this = $(this);
        var existTheme = $('.choose-skin li.active').data('theme');
        $('.choose-skin li').removeClass('active');
        $body.removeClass('theme-' + existTheme);
        $this.addClass('active');
        $body.addClass('theme-' + $this.data('theme'));
    });

    // gradient color active js
    $('.gradient-switch input:checkbox').on('click', function () {
        if($(this).is(":checked")) {
            $('.sidebar').addClass("gradient");
        } else {
            $('.sidebar').removeClass("gradient");
        }
    });

    // Dynamic theme color setting
    $('#primaryColorPicker').colorpicker().on('changeColor', function() {
        root.style.setProperty('--primary-color', $(this).colorpicker('getValue', '#ffffff'));
    });
    $('#secondaryColorPicker').colorpicker().on('changeColor', function() {
        root.style.setProperty('--secondary-color', $(this).colorpicker('getValue', '#ffffff'));
    });
    $('#chartColorPicker1').colorpicker().on('changeColor', function() {
        root.style.setProperty('--chart-color1', $(this).colorpicker('getValue', '#ffffff'));
    });
    $('#chartColorPicker2').colorpicker().on('changeColor', function() {
        root.style.setProperty('--chart-color2', $(this).colorpicker('getValue', '#ffffff'));
    });
    $('#chartColorPicker3').colorpicker().on('changeColor', function() {
        root.style.setProperty('--chart-color3', $(this).colorpicker('getValue', '#ffffff'));
    });
    $('#chartColorPicker4').colorpicker().on('changeColor', function() {
        root.style.setProperty('--chart-color4', $(this).colorpicker('getValue', '#ffffff'));
    });
    $('#chartColorPicker5').colorpicker().on('changeColor', function() {
        root.style.setProperty('--chart-color5', $(this).colorpicker('getValue', '#ffffff'));
    });
});

// light and dark theme setting js
$(function() {
    "use strict";
    var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    var toggleHcSwitch = document.querySelector('.theme-high-contrast input[type="checkbox"]');
    var currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        document.documentElement.setAttribute('data-theme', currentTheme);
    
        if (currentTheme === 'dark') {
            toggleSwitch.checked = true;
        }
        if (currentTheme === 'high-contrast') {
            toggleHcSwitch.checked = true;
            toggleSwitch.checked = false;
        }
    }
    function switchTheme(e) {
        if (e.target.checked) {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            $('.theme-high-contrast input[type="checkbox"]').prop("checked", false);
        }
        else {        
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        }    
    }
    function switchHc(e) {
        if (e.target.checked) {
            document.documentElement.setAttribute('data-theme', 'high-contrast');
            localStorage.setItem('theme', 'high-contrast');
            $('.theme-switch input[type="checkbox"]').prop("checked", false);
        }
        else {        
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        }  
    }
    toggleSwitch.addEventListener('change', switchTheme, false);
    toggleHcSwitch.addEventListener('change', switchHc, false);
});