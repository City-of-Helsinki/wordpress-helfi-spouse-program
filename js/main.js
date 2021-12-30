function spouse_focus(event){
  var modalNumber = event.target.classList[0].substr(-1);
  var id = "#wow-modal-window-"+modalNumber;
  var input = jQuery(id).find('input[type=text]').first();
  setTimeout(function(){
      input.focus();
    },
    1000
  )
}

// if link has class wow-modal-id-x, add spouse focus event to it automatically.
(jQuery('document').ready(function(){
  
  function handleFormSelectWithMessages(i,e){
    var el = jQuery(e);
    el.change(function () {
      var _index = jQuery("select", el).prop("selectedIndex");
      jQuery(".select-message", el).addClass("d-none").attr("aria-hidden", true);
      if (_index > 0){
        jQuery(jQuery( ".select-message", el)[_index-1]).removeClass("d-none").attr("aria-hidden", false);
      }
    })
    .change();
  
  }
  jQuery( ".form-select-with-messages" ).each(handleFormSelectWithMessages)

  jQuery("[class*=wow-modal-id-]").each(function(index, value){
    if(jQuery(this).closest('a').length){
      jQuery(this).on('click', spouse_focus);
    }
  })
}))

