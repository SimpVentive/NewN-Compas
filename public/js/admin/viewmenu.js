$(document).ready(function(){
    $('#nestable').nestable({
		collapsedClass	:	true,
		expandBtnHTML   : '<button data-action="expand" type="button">Expand</button>',
		collapseBtnHTML : '<button data-action="collapse" type="button">Collapse</button>'
    });
	 $('.dd').nestable('collapseAll');
});