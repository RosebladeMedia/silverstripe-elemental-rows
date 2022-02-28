(function ($) {
	$.entwine(function ($) {
		$('#Form_ItemEditForm_ColumnSetup').entwine({
			onchange: function () {
				var colSetup = this.val();

				var elementalArea3 = $('#Form_ItemEditForm_ElementalArea3'),
					elementalArea4 = $('#Form_ItemEditForm_ElementalArea4');

				if ((colSetup == "39") || (colSetup == "66") || (colSetup == "93")) {
					$(elementalArea3).hide();
					$(elementalArea4).hide();
				} else if ((colSetup == "363") || (colSetup == "444")) {
					$(elementalArea4).hide();
					$(elementalArea3).show();
				} else {
					$(elementalArea3).show();
					$(elementalArea4).show();
				}

				this._super();
			},
			onmatch: function () {
				var colSetup = this.val();

				var elementalArea3 = $('#Form_ItemEditForm_ElementalArea3'),
					elementalArea4 = $('#Form_ItemEditForm_ElementalArea4');

				if ((colSetup == "39") || (colSetup == "66") || (colSetup == "93")) {
					$(elementalArea3).hide();
					$(elementalArea4).hide();
				} else if ((colSetup == "363") || (colSetup == "444")) {
					$(elementalArea4).hide();
					$(elementalArea3).show();
				} else {
					$(elementalArea3).show();
					$(elementalArea4).show();
				}

				this._super();
			}
		});
	});
})(jQuery);