(() => {
  const instances = new Map();
  function initHeader(header) {
    if (!header || header.dataset.ready) return;
    header.dataset.ready = "yes";
    const nav = header.querySelector(".g12-drawer");
    const opener = header.querySelector(".g12-nav__open");
    const closer = header.querySelector(".g12-drawer__close");
    const mobile = matchMedia("(max-width:1100px)");
    const menu = header.querySelector(".g12-menu");
    const controller = new AbortController();
    function listen(target, name, callback, options = {}) {
      target.addEventListener(name, callback, { ...options, signal: controller.signal });
    }
    let layoutObserver;
    instances.set(header, () => {
      controller.abort();
      layoutObserver?.disconnect();
      clearTimeout(fallbackTimer);
      fallbackSpacer?.remove();
      if (header.classList.contains('has-open-menu')) document.body.classList.remove('g12-mega-scroll-locked');
    });

    const stickyEnabled = header.dataset.sticky === "yes";
    let fallbackSpacer;
    let fallbackTimer;

    function updateStickyFallback() {
      if (stickyEnabled) {
        header.classList.add("g12-fixed-fallback");
        if (!fallbackSpacer) {
          fallbackSpacer = document.createElement("div");
          fallbackSpacer.className = "g12-header-spacer";
          fallbackSpacer.setAttribute("aria-hidden", "true");
          header.after(fallbackSpacer);
        }
        // Keep the full header's space as it compacts, avoiding scroll jumps.
        if (!header.classList.contains('is-scrolled') || !fallbackSpacer.style.height) {
          fallbackSpacer.style.height = `${header.offsetHeight}px`;
        }
      }
    }

    function alignMegaMenus() {
      const navBox = header.querySelector(".g12-nav").getBoundingClientRect();
      const menuBox = menu.getBoundingClientRect();

      if (!mobile.matches) {
        const megaWidth = menuBox.width;
        const megaLeft = menuBox.left - navBox.left;
        header.style.setProperty("--g12-mega-left", `${megaLeft}px`);
        header.style.setProperty("--g12-mega-width", `${megaWidth}px`);
      } else {
        header.style.removeProperty("--g12-mega-left");
        header.style.removeProperty("--g12-mega-width");
      }
    }
    function setMenu(isOpen) {
      header.classList.toggle("has-open-menu", isOpen);
      document.body.classList.toggle("g12-mega-scroll-locked", isOpen);
      opener.setAttribute("aria-expanded", String(isOpen));
      if (isOpen) closer.focus();
      else if (mobile.matches) opener.focus();
    }
    opener.addEventListener("click", () => setMenu(true));
    closer.addEventListener("click", () => setMenu(false));
    header
      .querySelector(".g12-overlay")
      .addEventListener("click", () => setMenu(false));
    const items = [...header.querySelectorAll(".g12-menu > li")];
    items.forEach((item, i) => {
      const panel = item.querySelector(
        ":scope > .g12-mega, :scope > .g12-dropdown, :scope > .g12-ecosystem-panel",
      );
      if (!panel) return;
      const link = item.querySelector(":scope > a");
      panel.id ||= `g12-${header.dataset.instance}-submenu-${i}`;
      const button = document.createElement("button");
      button.className = "g12-submenu-toggle";
      button.type = "button";
      button.setAttribute(
        "aria-label",
        `Toggle ${link.textContent.trim()} submenu`,
      );
      button.setAttribute("aria-controls", panel.id);
      button.setAttribute("aria-expanded", "false");
      item.insertBefore(button, panel);
      link.setAttribute("aria-haspopup", "true");
      link.setAttribute("aria-expanded", "false");
      function toggle() {
        const isOpen = !item.classList.contains("is-open");
        items.forEach((other) => {
          other.classList.remove("is-open");
          other
            .querySelector(":scope > .g12-submenu-toggle")
            ?.setAttribute("aria-expanded", "false");
          other
            .querySelector(":scope > a")
            ?.setAttribute("aria-expanded", "false");
        });
        item.classList.remove("is-escape-closed");
        item.classList.toggle("is-open", isOpen);
        button.setAttribute("aria-expanded", String(isOpen));
        link.setAttribute("aria-expanded", String(isOpen));
      }
      button.addEventListener("click", toggle);
      if ((link.getAttribute("href") || "").startsWith("#"))
        link.addEventListener("click", (e) => {
          e.preventDefault();
          toggle();
        });
      item.addEventListener("mouseenter", () => {
        item.classList.remove("is-escape-closed");
        if (!mobile.matches) link.setAttribute("aria-expanded", "true");
      });
      item.addEventListener("mouseleave", () => {
        if (!mobile.matches) {
          item.classList.remove("is-open", "is-escape-closed");
          link.setAttribute("aria-expanded", "false");
        }
      });
    });
    header.querySelectorAll(".g12-mega__tabs .g12-tab").forEach((tab) => {
      tab.tabIndex = 0;
      tab.setAttribute("role", "button");
      const activate = () => {
        const menu = tab.closest(".g12-mega");
        const collapseCurrent =
          mobile.matches && tab.classList.contains("is-active");
        menu.querySelectorAll(".g12-tab").forEach((t) => {
          const active = !collapseCurrent && t === tab;
          t.classList.toggle("is-active", active);
          t.setAttribute("aria-pressed", String(active));
        });
        menu
          .querySelectorAll(".g12-mega__content")
          .forEach((pane) =>
            pane.classList.toggle(
              "is-active",
              !collapseCurrent && pane.id === tab.dataset.tab,
            ),
          );
        const activeContent = menu.querySelector(
          ".g12-mega__content.is-active",
        );
        if (!activeContent) return;
        if (!activeContent.querySelector(".g12-mega__panel.is-active"))
          activeContent
            .querySelector(".g12-mega__panel")
            ?.classList.add("is-active");
        if (!activeContent.querySelector(".g12-mega__side-tab.is-active")) {
          const firstSideTab = activeContent.querySelector(
            ".g12-mega__side-tab",
          );
          firstSideTab?.classList.add("is-active");
          firstSideTab?.setAttribute("aria-expanded", "true");
        }
      };
      tab.addEventListener("click", activate);
      tab.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          activate();
        }
      });
    });
    header.querySelectorAll(".g12-mega__side-tab").forEach((tab) => {
      tab.tabIndex = 0;
      tab.setAttribute("role", "button");
      const activate = (allowCollapse = false) => {
        const group = tab.closest(".g12-mega__content");
        const collapseCurrent =
          allowCollapse &&
          mobile.matches &&
          tab.classList.contains("is-active");
        group.querySelectorAll(".g12-mega__side-tab").forEach((t) => {
          const active = !collapseCurrent && t === tab;
          t.classList.toggle("is-active", active);
          t.setAttribute("aria-expanded", String(active));
        });
        group
          .querySelectorAll(".g12-mega__panel")
          .forEach((pane) =>
            pane.classList.toggle(
              "is-active",
              !collapseCurrent && pane.id === tab.dataset.inner,
            ),
          );
      };
      tab.addEventListener("mouseenter", () => {
        if (!mobile.matches) activate();
      });
      tab.addEventListener("focusin", () => {
        if (!mobile.matches) activate();
      });
      tab.addEventListener("click", (e) => {
        if (mobile.matches) e.preventDefault();
        activate(true);
      });
      tab.addEventListener("keydown", (e) => {
        if (e.key === " ") {
          e.preventDefault();
          activate();
        }
      });
    });

    const financeGroups = [...header.querySelectorAll(".g12-finance-group")];
    financeGroups.forEach((group, index) => {
      const heading = group.querySelector("h4");
      const list = group.querySelector("ul");
      if (!heading || !list) return;

      list.id ||= `g12-${header.dataset.instance}-finance-list-${index}`;
      heading.tabIndex = 0;
      heading.setAttribute("role", "button");
      heading.setAttribute("aria-controls", list.id);

      const setExpanded = (expanded) => {
        group.classList.toggle("is-open", expanded);
        heading.setAttribute("aria-expanded", String(expanded));
      };

      setExpanded(index === 0);

      const toggleGroup = () => {
        if (!mobile.matches) return;
        const willOpen = !group.classList.contains("is-open");
        financeGroups.forEach((other) => {
          other.classList.remove("is-open");
          other.querySelector("h4")?.setAttribute("aria-expanded", "false");
        });
        setExpanded(willOpen);
      };

      heading.addEventListener("click", toggleGroup);
      heading.addEventListener("keydown", (event) => {
        if (event.key === "Enter" || event.key === " ") {
          event.preventDefault();
          toggleGroup();
        }
      });
    });

    const businessMenu = header.querySelector(".g12-business-menu > .g12-mega");
    const businessTabs = businessMenu
      ? [...businessMenu.querySelectorAll(".g12-mega__tabs .g12-tab")]
      : [];
    const businessTabList = businessMenu?.querySelector(".g12-mega__tabs");
    const nestedBusinessGroups = businessMenu
      ? [...businessMenu.querySelectorAll(".g12-mega__content")].map(
          (content) => ({
            content,
            sidebar: content.querySelector(".g12-mega__side-tabs"),
            tabList: content.querySelector(".g12-mega__side-tabs > ul"),
            body: content.querySelector(".g12-mega__panels"),
            tabs: [...content.querySelectorAll(".g12-mega__side-tab")],
            panels: [...content.querySelectorAll(".g12-mega__panel")],
          }),
        )
      : [];
    const syncBusinessAccordion = () => {
      if (!businessMenu || !businessTabList) return;
      if (mobile.matches) {
        businessTabs.forEach((tab) => {
          const panel = businessMenu.querySelector(`#${tab.dataset.tab}`);
          if (panel) businessMenu.insertBefore(tab, panel);
        });
        nestedBusinessGroups.forEach(({ content, tabs, panels }) => {
          tabs.forEach((tab) => {
            const panel = panels.find((item) => item.id === tab.dataset.inner);
            content.append(tab);
            if (panel) content.append(panel);
          });
        });
      } else {
        businessTabs.forEach((tab) => businessTabList.append(tab));
        businessMenu.prepend(businessTabList);
        nestedBusinessGroups.forEach(
          ({ sidebar, tabList, body, tabs, panels }) => {
            tabs.forEach((tab) => tabList?.append(tab));
            panels.forEach((panel) => body?.append(panel));
            if (sidebar && tabList) sidebar.append(tabList);
          },
        );
      }
    };
    syncBusinessAccordion();

    listen(document, "keydown", (e) => {
      if (e.key === "Escape") {
        if (!header.isConnected) return;
        const activeItem = header.contains(document.activeElement) ? document.activeElement.closest(".g12-menu > li") : null;
        if (
          activeItem?.querySelector(
            ".g12-mega,.g12-dropdown,.g12-ecosystem-panel",
          ) &&
          !mobile.matches
        ) {
          activeItem.classList.remove("is-open");
          activeItem.classList.add("is-escape-closed");
          activeItem.querySelector(":scope > a").focus();
        } else if (header.classList.contains("has-open-menu")) setMenu(false);
      }
      if (e.key === "Tab" && header.classList.contains("has-open-menu")) {
        const links = [
          ...nav.querySelectorAll('a,button,[tabindex="0"]'),
        ].filter((el) => el.getClientRects().length);
        const first = links[0],
          last = links[links.length - 1];
        if (e.shiftKey && document.activeElement === first) {
          e.preventDefault();
          last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
    });
    listen(document, "click", (e) => {
      if (!header.contains(e.target))
        items.forEach((item) => item.classList.remove("is-open"));
    });
    listen(mobile, "change", () => {
      setMenu(false);
      items.forEach((item) => item.classList.remove("is-open"));
      syncBusinessAccordion();
      alignMegaMenus();
    });
    listen(window, "resize", alignMegaMenus, { passive: true });
    listen(window, "resize", updateStickyFallback, { passive: true });
    if ("ResizeObserver" in window) {
      layoutObserver = new ResizeObserver(() => {
        alignMegaMenus();
        updateStickyFallback();
      });
      layoutObserver.observe(menu);
      layoutObserver.observe(header.querySelector(".g12-nav"));
      layoutObserver.observe(header);
    }
    alignMegaMenus();
    updateStickyFallback();
    let isCompact = false;
    const scroll = () => {
      if (!isCompact && scrollY > 80) {
        isCompact = true;
      } else if (isCompact && scrollY <= 2) {
        isCompact = false;
      }

      header.classList.toggle("is-scrolled", isCompact);
      if (stickyEnabled) {
        clearTimeout(fallbackTimer);
        fallbackTimer = setTimeout(updateStickyFallback, 350);
      }
    };
    listen(window, "scroll", scroll, { passive: true });
    scroll();
  }

  function boot(scope = document) { scope.querySelectorAll('[data-g12-mega-header]').forEach(initHeader); }
  const removals = new MutationObserver(() => {
    instances.forEach((cleanup, header) => {
      if (!header.isConnected) { cleanup(); instances.delete(header); }
    });
  });
  removals.observe(document.documentElement, { childList: true, subtree: true });
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', () => boot());
  else boot();
  let editorHookRegistered = false;
  function editorHook() {
    if (editorHookRegistered || !window.elementorFrontend?.hooks) return;
    editorHookRegistered = true;
    window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_mega_header.default', scope => boot(scope[0] || scope));
  }
  editorHook();
  if (window.jQuery) window.jQuery(window).on('elementor/frontend/init', editorHook);
  else window.addEventListener('elementor/frontend/init', editorHook);
})();
