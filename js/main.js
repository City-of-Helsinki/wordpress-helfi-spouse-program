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

  jQuery("[class*=wow-modal-id-]").each(function (index, value) {
    if (jQuery(this).closest("a").length) {
      jQuery(this).on("click", spouse_focus);
    }
  });

  // redirect CF7 Forms
  document.addEventListener( 'wpcf7mailsent', function( event ) {
      location = mainVars.thankYouPage;
  }, false );
});

// LOAD MORE CONTENT FUNCTIONS
function loadMoreContent(contentType) {
  const config = {
      events: { buttonId: "load-more-events", actionType: "spouse_load_more_events" },
      newsletters: { buttonId: "load-more-newsletters", actionType: "spouse_load_more_newsletters" }
  };

  const { buttonId, actionType } = config[contentType] || {};
  const buttonElement = document.getElementById(buttonId);
  if (!buttonElement) return;

  let paged = parseInt(buttonElement.dataset.paged) + 1;
  let taxonomyFilter = buttonElement.dataset.taxonomy || "all";

  fetch(spouseAjax.ajaxurl, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ action: actionType, paged, taxonomy: taxonomyFilter })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success && data.data.html) {
          document.querySelector("#load-more-container").insertAdjacentHTML("beforeend", data.data.html);
          buttonElement.dataset.paged = paged;
          if (!data.data.has_more) buttonElement.style.display = "none";
      }
  })
  .catch(error => console.error("Error with AJAX request:", error));
}

// Event listeners for load more functions
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".taxonomy-filter-button").forEach(button => {
      button.addEventListener("click", () => {
          const taxonomy = button.dataset.filter;
          filterEventsByTaxonomy(taxonomy);
      });
  });

  document.addEventListener("click", (e) => {
      if (e.target.matches("#load-more-events, #load-more-newsletters")) {
          e.preventDefault();
          loadMoreContent(e.target.id.includes("events") ? "events" : "newsletters");
      }
  });

  // Handle accordions in the activities archive page
  document.querySelectorAll(".year-toggle").forEach(link => {
      link.addEventListener("click", () => {
          const year = link.dataset.year;
          const content = document.getElementById(`year-${year}`);
          const arrow = link.querySelector(".arrow");

          document.querySelectorAll(".year-content").forEach(el => el.style.display = el === content && el.style.display !== "block" ? "block" : "none");
          document.querySelectorAll(".year-toggle").forEach(btn => {
              const btnArrow = btn.querySelector(".arrow");
              btn.classList.toggle("active", btn === link && content.style.display === "block");
              btnArrow.classList.toggle("arrow-up", btn === link && content.style.display === "block");
              btnArrow.classList.toggle("arrow-down", !(btn === link && content.style.display === "block"));
          });
      });
  });

    // Focus the first heading element on the site when skip to main content button is clicked
    document.getElementById("skip-to-main-content")?.addEventListener("click", (e) => {
        e.preventDefault();

        const main = document.getElementById("main-content");

        if (!main) {
            return;
        }

        const firstHeading = document.querySelector('h1, h2, h3, h4, h5, h6');

        // Target first heading, if not found use the main content area
        const target = firstHeading || main;

        target.setAttribute('tabindex', '-1');
        target.focus();
    });
});

// Filter events by taxonomy
function filterEventsByTaxonomy(taxonomy) {
  const newUrl = new URL(window.location.href);
  newUrl.searchParams.set("taxonomy", taxonomy);
  window.location.href = newUrl;
}
