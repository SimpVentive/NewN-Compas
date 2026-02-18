(function() {
	'user strict';

	var nCompass = function() {
		var n = this;
		$(document).ready(function() {
			n._initialize();
			n._sidePanelSlider();
			n._initScroll();
			n._initInbasketExam();
			n._initInbasketExamNav();
			n._initIDPNav();
			n._initSectionScrolling();
		});
	};

	var n = nCompass.prototype;

	n._initialize = function () {
			Waves.init();
			Waves.attach('.waves-effect', ['waves-button', 'waves-float']);

			$('.more-option .nav-link').on('click', function (){
				$('#slide-drawer').toggleClass('active');
			});

			$('.mobile-menu').on('click', function (){
				$('.side-panel-section').toggleClass('active');
			});
	};
	n._sidePanelSlider = function () {
		if($('.side-panel-section')){
			$('.side-panel-section').scrollbar();
		}
	};

	n._initScroll = function () {
		if($('.custom-scroll')){
			$('.custom-scroll').scrollbar();
		}
	};

	n._initInbasketExam = function (){
		$('.inbasket-exam-btn').on('click', function (e){
			$('#inbasket-exam-option').slideToggle();
			$(this).parents('.assessment-box').toggleClass('active');
		});
	}

	n._initInbasketExamNav = function (){
		$('.nav-back-btn').on('click', function (e){
			let navPanel = $('.test-nav-panel');
			let tabID = navPanel.find('li.active').prev('li.active').last().data('tab-id');
			if(tabID){
				$('.tast-tab-nav').hide();
				$('#'+tabID).show();
				navPanel.find('li.active').last().removeClass('active');
			}
		});

		$('.nav-next-btn').on('click', function (e){
			let navPanel = $('.test-nav-panel');
			let tabID = navPanel.find('li.active:last').next('li').data('tab-id');
			if(tabID){
				$('.tast-tab-nav').hide();
				$('#'+tabID).show();
				navPanel.find('li.active:last').next('li').addClass('active');
			}//else{
				//window.location.href = "assessment-test-complete.php";
				//document.getElementById("inbasket_submit").submit();
			//}
		});
	}

	n._initIDPNav = function (){
		let counter = 1;
		$('.idp-nav-back-btn').on('click', function (e){
			let navPanel = $('.test-nav-panel');
			let tabID = navPanel.find('li.active').prev('li.active').last().data('tab-id');
			if(tabID){
				counter--;
				$('#taskID').text(counter);
				$('.tast-tab-nav').hide();
				$('#'+tabID).show();
				navPanel.find('li.active').last().removeClass('active');
			}else{
				window.location.href = "idp-process-dashboard.php";
			}
		});

		$('.idp-nav-next-btn').on('click', function (e){
			let navPanel = $('.test-nav-panel');
			let tabID = navPanel.find('li.active:last').next('li').data('tab-id');
			if(tabID){
				counter++;
				$('#taskID').text(counter);
				$('.tast-tab-nav').hide();
				$('#'+tabID).show();
				navPanel.find('li.active:last').next('li').addClass('active');
			}else{
				let redirect = $(this).data('redirect');
				window.location.href = redirect;
			}
		});
	}

	n._initSectionScrolling = function (){
		$('.section-to-scroll').on('click', function (e){

			var section = $(this).attr('data-section');
			var position = $(this).attr('data-position');
			var tabNumber = Number($(this).attr('data-tab'));
			
			$('.year-tab-section .nav-tabs .nav-item .nav-link').removeClass('active');
			$(this).addClass('active');

			var prevTabPane = $('#'+section).prev('div.tab-pane').outerWidth();
			$("#scrolling-section"+position).animate({
				scrollLeft : (prevTabPane * tabNumber)
			}, 1000);

		});
	};

	window.nCompassApp = window.nCompassApp || {};
	window.nCompassApp.nCompass = new nCompass();
})(jQuery);