// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {
	onShiftEnter:	{keepDefault:false, replaceWith:'<br />\n'},
	onCtrlEnter:	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>\n'},
	onTab:			{keepDefault:false, openWith:'	 '},
	markupSet: [
		/*{name:'Heading 1', key:'1', openWith:'<h1(!( class="[![Class]!]")!)>', closeWith:'</h1>', placeHolder:'Your title here...' },
		{name:'Heading 2', key:'2', openWith:'<h2(!( class="[![Class]!]")!)>', closeWith:'</h2>', placeHolder:'Your title here...' },
		{name:'Heading 3', key:'3', openWith:'<h3(!( class="[![Class]!]")!)>', closeWith:'</h3>', placeHolder:'Your title here...' },*/
		{name:'h4', key:'4', className:'h4', openWith:'<h4(!( class="[![Class]!]")!)>', closeWith:'</h4>', placeHolder:'' },
		{name:'h5', key:'5', className:'h5',openWith:'<h5(!( class="[![Class]!]")!)>', closeWith:'</h5>', placeHolder:'' },
		{name:'h6', key:'6', className:'h6',openWith:'<h6(!( class="[![Class]!]")!)>', closeWith:'</h6>', placeHolder:'' },
		{name:'p', className:'p', openBlockWith:'<p(!( class="[![Class]!]")!)>', closeBlockWith:'</p>' },
		{name:'blockquote', className:'blockquote', openWith:'<blockquote(!( class="[![Class]!]")!)><p>', closeWith:'</p></blockquote>' },
		{separator:'---------------' },
		{name:'Bold', key:'B', className:'strong', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
		{name:'Italic', key:'I', className:'italic', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)' },
		{name:'Stroke through', className:'stroke', key:'S', openWith:'<del>', closeWith:'</del>' },
		{separator:'---------------' },
		{name:'ul', className:'ul', openWith:'<ul>\n', closeWith:'</ul>\n' },
		{name:'ol', className:'ol', openWith:'<ol>\n', closeWith:'</ol>\n' },
		{name:'li', className:'li', openWith:'<li>', closeWith:'</li>' },
		{separator:'---------------' },
		{name:'img', className:'img', replaceWith:'<img src="[![Source:!:http://]!]" alt="[![Alternative text]!]" />' },
		{name:'a', className:'a', openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'' },
		{separator:'---------------' },
		{name:'Clean', className:'clean', replaceWith:function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
		{name:'Preview', key:'P', className:'preview', call:'preview' },
		{separator:'---------------' },
		{	name:'', className:'lorem', dropMenu: [
				{name:'Lorem ipsum...', className:'lorem-special', replaceWith:'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.' },
				{name:'Suspendisse...', className:'lorem-special', replaceWith:'Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.' },
				{name:'Maecenas...', className:'lorem-special', replaceWith:'Maecenas ligula massa, varius a, semper congue, euismod non, mi.' },
				{name:'Proin porttitor...', className:'lorem-special', replaceWith:'Proin porttitor, orci nec nonummy molestie, non fermentum diam nisl sit amet erat.' },
				{name:'Duis arcu...', className:'lorem-special', replaceWith:'Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim.' },
				{name:'Long paragraph', replaceWith:'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean ut orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula. Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam. Integer quis metus vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi vel erat non mauris convallis vehicula. Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue non elementum posuere, metus purus iaculis lectus, et tristique ligula justo vitae magna.' }
			]
		},
		{	name:'Encode Html special chars',
			className:"encodechars", 
			replaceWith:function(markItUp) { 
				var container = document.createElement('div');
				container.appendChild(document.createTextNode(markItUp.selection));
				return container.innerHTML; 
			}
		}
	

	]
}
