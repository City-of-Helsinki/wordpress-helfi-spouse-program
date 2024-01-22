function spouse_focus(event) {
  var modalNumber = event.target.classList[0].substr(-1);
  var id = "#wow-modal-window-" + modalNumber;
  var input = jQuery(id).find("input[type=text]").first();
  setTimeout(function () {
    input.focus();
  }, 1000);
}

function isValidUrl(url) {
  try {
    new URL(url);
  } catch (e) {
    return false;
  }

  return true;
}

function addExternalLinkStyling(link) {
  const UNDESIRABLE_PARENTS = ".share, .service-link";

  if (jQuery(link).parents(UNDESIRABLE_PARENTS).length === 0) {
    link.classList.add("external-link");
    addExternalLinkIcon(link);
  }
}

function addExternalLinkIcon(link) {
  const ARROW_SVG_RIGHT =
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.6 32.1" xml:space="preserve" role="presentation"><path style="fill-rule:evenodd;clip-rule:evenodd" d="M32.6 16.1 16.5 0l-2.8 2.8 11.4 11.3H0v4h25L13.7 29.3l2.8 2.8z"></path></svg>';

  const svgArrow45 =
    '<span class="inline-svg rotate-45">' + ARROW_SVG_RIGHT + "</span>";
  const inlineSVG = link.querySelector(".inline-svg");

  if (inlineSVG === null) {
    jQuery(link).append(svgArrow45);
    jQuery(link).append(
      '<span class="visually-hidden" lang="fi" dir="ltr">(Link leads to external service)</span>'
    );
  }
}

function addInternalLinkIcon(link) {
  const ARROW_SVG_RIGHT =
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.6 32.1" xml:space="preserve" role="presentation"><path style="fill-rule:evenodd;clip-rule:evenodd" d="M32.6 16.1 16.5 0l-2.8 2.8 11.4 11.3H0v4h25L13.7 29.3l2.8 2.8z"></path></svg>';

  const svgArrow45 =
    '<span class="inline-svg rotate-0">' + ARROW_SVG_RIGHT + "</span>";
  const inlineSVG = link.querySelector(".inline-svg");

  if (inlineSVG === null) {
    jQuery(link).append(svgArrow45);
  }
}

function detectExternalLinks(item) {
  const locationHostname = window.location.hostname;
  const links = document.querySelectorAll(item);
  for (let i = 0; i < links.length; i++) {
    if (isValidUrl(links[i])) {
      let domain = new URL(links[i]);
      let linkHostname = domain.hostname.replace("www.", "");
      var childImg = links[i].getElementsByTagName("img");
      if (
        linkHostname &&
        locationHostname !== linkHostname &&
        !linkHostname.includes("spouseprogram.fi") &&
        !links[i].classList.contains("venobox") &&
        !links[i].classList.contains("fancybox-youtube") &&
        !links[i].classList.contains("button") &&
        !childImg.length
      ) {
        addExternalLinkStyling(links[i]);
      } else {
        if (links[i].classList.contains("arrow")) {
          addInternalLinkIcon(links[i]);
        }
      }
    }
  }
}

function highlightedContentHelperClass(item) {
  const paragraphs = document.querySelectorAll(item);
  for (let i = 0; i < paragraphs.length; i++) {
    const text = paragraphs[i].outerHTML;

    if (
      !text.startsWith("<p><a") &&
      !text.startsWith("<p><strong><a") &&
      !text.startsWith("<p><i><a")
    ) {
      jQuery(paragraphs[i]).prepend("<span></span>");
    }
  }
}

// if link has class wow-modal-id-x, add spouse focus event to it automatically.
jQuery("document").ready(function () {
  detectExternalLinks("#main-content a");
  highlightedContentHelperClass("#main-content .highlighted-content p");

  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();

      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth",
      });
    });
  });

  function handleFormSelectWithMessages(i, e) {
    var el = jQuery(e);
    el.change(function () {
      var _index = jQuery("select", el).prop("selectedIndex");
      jQuery(".select-message", el)
        .addClass("d-none")
        .attr("aria-hidden", true);
      if (_index > 0) {
        jQuery(jQuery(".select-message", el)[_index - 1])
          .removeClass("d-none")
          .attr("aria-hidden", false);
      }
    }).change();
  }
  jQuery(".form-select-with-messages").each(handleFormSelectWithMessages);

  jQuery("[class*=wow-modal-id-]").each(function (index, value) {
    if (jQuery(this).closest("a").length) {
      jQuery(this).on("click", spouse_focus);
    }
  });
});
