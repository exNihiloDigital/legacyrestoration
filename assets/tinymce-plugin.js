// (function(){
//     tinymce.create('tinymce.plugins.insertBtnBtn', {

//         init: function(ed, url){
//             ed.addButton('insertbtn',{
//                 title: 'Insert Button',
//                 cmd: 'insertbtnCmd',
//                 image: url + '/images/insertBtn.png'
//             });
//             ed.addCommand('insertbtnCmd', function(){
//                 var selectedText = ed.selection.getContent({format: 'html'});

//                 var win = ed.windowManager.open({
//                   title: "Button Link",
//                   body: [
//                     {
//                         type: "textbox",
//                         name: "buttonlink",
//                         label: "Button Link",
//                         minWidth: 500,
//                         value: ""
//                     },
//                     {
//                         type: "textbox",
//                         name: "buttontext",
//                         label: "Button Text",
//                         minWidth: 500,
//                         value: ""
//                     }
//                   ],
//                   buttons: [
//                         {
//                             text: 'OK',
//                             subtype: 'primary',
//                             onclick: function(){
//                                 win.submit();
//                             }
//                         },
//                         {
//                             text: 'Cancel',
//                             onclick: function () {
//                                 win.close();
//                             }
//                         }
//                   ],
//                   onsubmit: function(e){
//                       var params = [];
//                       if(e.data.buttonlink.length > 0){
//                           params.push('buttonlink=' +e.data.buttonlink);
//                       }
//                       if(e.data.buttontext.length > 0){
//                           params.push('buttontext=' +e.data.buttontext);
//                       }
//                       if(params.length > 0){
//                           paramsString = ' ' + params.join(' ');
//                       }
//                       var returnText = '<a href="">' + params[1] + '</a>';

//                       edexecCommand('mceInsertContent', 0, returnText);
//                   }
//                 });
//             });
//         },
//         getInfo: function() {
//             return{
//                 longname: 'Insert Button',
//                 author: 'Mike Rogowski',
//                 authorurl: 'https://phoscreative.com',
//                 version: '1.0.0'
//             };
//         }
//     });
//     tinymce.PluginManager.add('insertbtn', tinymce.plugins.insertBtnBtn);
// });

// (function () {
//     tinymce.create('tinymce.plugins.MyPluginName', {
//         init: function (ed, url) {
//             ed.addButton('myblockquotebtn', {
//                 title: 'My Blockquote',
//                 cmd: 'myBlockquoteBtnCmd',
//                 image: url + 'insertBtn.png'
//             });
//             ed.addCommand('myBlockquoteBtnCmd', function () {
//                 var selectedText = ed.selection.getContent({ format: 'html' });
//                 var win = ed.windowManager.open({
//                     title: 'Blockquote Properties',
//                     body: [
//                         {
//                             type: 'textbox',
//                             name: 'author',
//                             label: 'Quote Author',
//                             minWidth: 500,
//                             value: ''
//                         },
//                         {
//                             type: 'textbox',
//                             name: 'cite',
//                             label: 'Quote Citation',
//                             minWidth: 500,
//                             value: ''
//                         },
//                         {
//                             type: 'textbox',
//                             name: 'link',
//                             label: 'Citation URL',
//                             minWidth: 500,
//                             value: ''
//                         }
//                     ],
//                     buttons: [
//                         {
//                             text: "Ok",
//                             subtype: "primary",
//                             onclick: function () {
//                                 win.submit();
//                             }
//                         },
//                         {
//                             text: "Skip",
//                             onclick: function () {
//                                 win.close();
//                                 var returnText = 'TEST';
//                                 ed.execCommand('mceInsertContent', 0, returnText);
//                             }
//                         },
//                         {
//                             text: "Cancel",
//                             onclick: function () {
//                                 win.close();
//                             }
//                         }
//                     ],
//                     onsubmit: function (e) {
//                         var params = [];
//                         if (e.data.author.length > 0) {
//                             params.push('author="' + e.data.author + '"');
//                         }
//                         if (e.data.cite.length > 0) {
//                             params.push('cite="' + e.data.cite + '"');
//                         }
//                         if (e.data.link.length > 0) {
//                             params.push('link="' + e.data.link + '"');
//                         }
//                         if (params.length > 0) {
//                             paramsString = ' ' + params.join(' ');
//                         }
//                         var returnText = 'TEST';
//                         ed.execCommand('mceInsertContent', 0, returnText);
//                     }
//                 });
//             });
//         },
//         getInfo: function () {
//             return {
//                 longname: 'My Custom Buttons',
//                 author: 'Plugin Author',
//                 authorurl: 'https://www.axosoft.com',
//                 version: "1.0"
//             };
//         }
//     });
//     tinymce.PluginManager.add('mytinymceplugin', tinymce.plugins.MyPluginName);
// })();

//=========================================================================================
//  Add TinyMCE Button to editor
//=========================================================================================
(function () {
    tinymce.PluginManager.add('phos_tc_button', function (editor, url) {
        editor.addButton('phos_tc_button', {
            title: 'Insert Button Link',
            icon: 'icon dashicons-marker',
            onclick: function () {
                // editor.insertContent('<a href="" class="button">Button Goes Here</a>');
                editor.windowManager.open({
                    title: 'Button Link',
                    body: [{
                        type: 'textbox',
                        name: 'link',
                        label: 'Link'
                    },
                    {
                        type: 'textbox',
                        name: 'button_text',
                        label: 'Text'
                    },
                    {
                        type: 'radio',
                        name: 'target',
                        label: 'New Tab',
                    }
                    ],
                    onsubmit: function (e) {
                        var linkTarget = '';
                        if(e.data.target === true){
                            linkTarget = "_blank";
                        } else{
                            linkTarget = "_self";
                        }
                        editor.insertContent('<a href="' + e.data.link + '" class="button" target="' + linkTarget + '">' + e.data.button_text + '</a>');
                    }
                });
            }
        });
    });
})();