<script type="text/javascript">
	function format_currency(el) {
		var currEl = el.clone();
		currEl.removeAttr('id');
		currEl.removeAttr('name');
		var currency = get_currency( el.val() );
		currency = currency.replace(/,[0-9]*/, ''); 
		currEl.val(
			currency
		);
		currEl.keyup(function(){
			var val = $(this).val();
			val = val.replace(/([0-9.]*),[0-9]*/, '$1');
			var nonDigitPtr = /\D/g;
			var res = val.split('');
			if(res.length > 3) {
				res = res.reverse().join('');
				res = res.replace(nonDigitPtr, '');
				var currPtr = /(\w{3})/g;
				var currStr = res.replace(currPtr, '$1.').split('').reverse().join('').replace(/^\.(.*)/, '$1');
				currStr = currStr.replace(/^\.(.*)/, '$1');
				$(this).val(currStr);
				res = res.split('').reverse().join('');
			}
			else {
				res = val;
			}
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