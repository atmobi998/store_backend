/**
 * Every rich text editor plugin is expected to come with a wysiwyg.js file,
 * and should follow the same structure.
 *
 * This makes sure there is consistency among multiple RTE plugins.
 */
if (typeof Atcmobapp.Wysiwyg == 'undefined') {
  // Atcmobapp.uploadsPath and Atcmobapp.attachmentsPath is set from Helper anyways
  Atcmobapp.Wysiwyg = {
    uploadsPath: Atcmobapp.basePath + 'uploads/',
    attachmentsPath: Atcmobapp.basePath + 'admin/file-manager/attachments/browse'
  };
}

/**
 * This function is called when you select an image file to be inserted in your editor.
 */
Atcmobapp.Wysiwyg.choose = function(url, title, description) {

};

/**
 * Returns boolean value to indicate an editor within the page has been modified
 */
Atcmobapp.Wysiwyg.isDirty = function() {
};

/**
 * Reset dirty indicator for all editors in the page
 */
Atcmobapp.Wysiwyg.resetDirty = function() {
};

/**
 * This function is responsible for integrating attachments/file browser in the editor.
 */
Atcmobapp.Wysiwyg.browser = function() {
};

Atcmobapp.Wysiwyg._$btnContainer = {};

Atcmobapp.Wysiwyg._addButtonContainer = function($el) {
  var elementId = $el.attr('id');
  if (Atcmobapp.Wysiwyg._$btnContainer[elementId] == null) {
    var $btnContainer = $el.siblings('.btn-group');
    if ($btnContainer.length == 0) {
        $btnContainer = $('<div class="btn-group float-right"/>');
    }
    $btnContainer.insertBefore($el);
    Atcmobapp.Wysiwyg._$btnContainer[elementId] = $btnContainer;
  }
};

Atcmobapp.Wysiwyg.addButton = function($el, title, onButtonClicked) {
  var elementId = $el.attr('id');
  Atcmobapp.Wysiwyg._addButtonContainer($el);
  var $btn = $('<button type="button"/>')
    .attr('class', 'btn btn-sm btn-outline-secondary')
    .html(title)
    .on('click', onButtonClicked);
  Atcmobapp.Wysiwyg._$btnContainer[elementId].append($btn);
  var buttons = $('.btn', Atcmobapp.Wysiwyg._$btnContainer[elementId]);
  if (buttons.length == 1) {
    setTimeout(function() {
      $('.btn:first-child', Atcmobapp.Wysiwyg._$btnContainer[elementId])
        .trigger('click');
    }, 300);
  }
};

if (typeof jQuery != 'undefined') {
  $(document).ready(function() {
    Atcmobapp.Wysiwyg.browser();
  });
}
