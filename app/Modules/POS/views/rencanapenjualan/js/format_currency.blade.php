<script type="text/javascript">
	function format_currency(el) {
		var currEl = el.clone();
		currEl.removeAttr('id');
		currEl.removeAttr('name');
		currEl.keyup(function(){
			var nonDigitPtr = /\D/g;
			var val = $(this).val();
			var res = val.split('');
			res = res.reverse().join('');
			res = res.replace(nonDigitPtr, '');
			if(res.length > 3) {
				var currPtr = /(\w{3})/g;
				var currStr = res.replace(currPtr, '$1,').split('').reverse().join('').replace(/^\.(.*)/, '$1');
				$(this).val(currStr);
			}
			res = res.split('').reverse().join('');
			el.val(res);
		});
		el.addClass('hidden'); 
		el.after(currEl);
	}

	function get_currency(v) {
		if( /^\d([0-9\.]+)$/.test(v) ) {

			var desimal = '';
			if( /\./.test(v) ==  true ) {
				v = parseFloat(v);
				v = v.toFixed(2);
				v = v.toString();
				desimal = v.split('.')[1];
				v = v.split('.')[0];
			}


			v = v.toString();
			var res = v.split('');
			res = res.reverse().join('');
			currStr = v;
			if(res.length > 3) {
				var currPtr = /(\w{3})/g;
				var currStr = res.replace(currPtr, '$1.').split('').reverse().join('').replace(/^\.(.*)/, '$1');
			}


			currStr += desimal != '' ? ',' + desimal : '';
			return currStr;
		}

		return v;
	}

</script>