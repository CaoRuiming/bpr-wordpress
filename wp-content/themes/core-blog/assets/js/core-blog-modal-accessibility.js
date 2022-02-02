var coreblog = coreblog || {};
function coreblogDomReady(e) {
    if ("function" == typeof e) return "interactive" === document.readyState || "complete" === document.readyState ? e() : void document.addEventListener("DOMContentLoaded", e, !1);
}
function coreblogToggleAttribute(e, t, o, n) {
    void 0 === o && (o = !0), void 0 === n && (n = !1), e.getAttribute(t) !== o ? e.setAttribute(t, o) : e.setAttribute(t, n);
}
function coreblogFindParents(e, o) {
    var n = [];
    return (
        (function e(t) {
            t = t.parentNode;
            t instanceof HTMLElement && (t.matches(o) && n.push(t), e(t));
        })(e),
        n
    );
}
(coreblog.createEvent = function (e) {
    var t;
    return "function" == typeof window.Event ? (t = new Event(e)) : (t = document.createEvent("Event")).initEvent(e, !0, !1), t;
}),
    (coreblog.coverModals = {
        init: function () {
            document.querySelector(".cover-modal") && (this.onToggle(), this.closeOnEscape(), this.hideAndShowModals(), this.keepFocusInModal());
        },
        onToggle: function () {
            document.querySelectorAll(".cover-modal").forEach(function (e) {
                e.addEventListener("toggled", function (e) {
                    var e = e.target,
                        t = document.body;
                    e.classList.contains("active")
                        ? t.classList.add("showing-modal")
                        : (t.classList.remove("showing-modal"),
                          t.classList.add("hiding-modal"),
                          setTimeout(function () {
                              t.classList.remove("hiding-modal");
                          }, 500));
                });
            });
        },
        closeOnEscape: function () {
            document.addEventListener(
                "keydown",
                function (e) {
                    27 === e.keyCode &&
                        (e.preventDefault(),
                        document.querySelectorAll(".cover-modal.active").forEach(
                            function (e) {
                                this.untoggleModal(e);
                            }.bind(this)
                        ));
                }.bind(this)
            );
        },
        hideAndShowModals: function () {
            var i = document,
                c = window,
                e = i.querySelectorAll(".cover-modal"),
                a = i.documentElement.style,
                r = i.querySelector("#wpadminbar");
            function d(e) {
                var t,
                    o = c.pageYOffset;
                return r ? ((t = o + r.getBoundingClientRect().height), e ? -t : t) : 0 === o ? 0 : -o;
            }
            function u() {
                return { "overflow-y": c.innerHeight > i.documentElement.getBoundingClientRect().height ? "hidden" : "scroll", position: "fixed", width: "100%", top: d(!0) + "px", left: 0 };
            }
            e.forEach(function (l) {
                l.addEventListener("toggle-target-before-inactive", function (e) {
                    var t = u(),
                        o = c.pageYOffset,
                        n = Math.abs(d()) - o + "px",
                        s = c.matchMedia("(max-width: 600px)");
                    e.target === l &&
                        (Object.keys(t).forEach(function (e) {
                            a.setProperty(e, t[e]);
                        }),
                        (c.coreblog.scrolled = parseInt(t.top, 10)),
                        r && (i.body.style.setProperty("padding-top", n), s.matches && (o >= d() ? l.style.setProperty("top", 0) : l.style.setProperty("top", d() - o + "px"))),
                        l.classList.add("show-modal"));
                }),
                    l.addEventListener("toggle-target-after-inactive", function (e) {
                        e.target === l &&
                            setTimeout(function () {
                                var e = coreblog.toggles.clickedEl;
                                l.classList.remove("show-modal"),
                                    Object.keys(u()).forEach(function (e) {
                                        a.removeProperty(e);
                                    }),
                                    r && (i.body.style.removeProperty("padding-top"), l.style.removeProperty("top")),
                                    !1 !== e && (e.focus(), (e = !1)),
                                    c.scrollTo(0, Math.abs(c.coreblog.scrolled + d())),
                                    (c.coreblog.scrolled = 0);
                            }, 500);
                    });
            });
        },
        untoggleModal: function (e) {
            var t,
                o = !1;
            e.dataset.modalTargetString && ((t = e.dataset.modalTargetString), (o = document.querySelector('*[data-toggle-target="' + t + '"]'))), o ? o.click() : e.classList.remove("active");
        },
        keepFocusInModal: function () {
            var a = document;
            a.addEventListener("keydown", function (e) {
                var t,
                    o,
                    n,
                    s,
                    l,
                    i,
                    c = coreblog.toggles.clickedEl;
                c &&
                    a.body.classList.contains("showing-modal") &&
                    ((n = c.dataset.toggleTarget),
                    (i = "input, a, button"),
                    (s = a.querySelector(n)),
                    (t = s.querySelectorAll(i)),
                    (t = Array.prototype.slice.call(t)),
                    ".menu-modal" === n &&
                        ((o = (o = window.matchMedia("(min-width: 768px)").matches) ? ".expanded-menu" : ".mobile-menu"),
                        (t = t.filter(function (e) {
                            return null !== e.closest(o) && null !== e.offsetParent;
                        })).unshift(a.querySelector(".close-nav-toggle")),
                        (l = a.querySelector(".menu-bottom > nav")) &&
                            l.querySelectorAll(i).forEach(function (e) {
                                t.push(e);
                            })),
                    ".main-menu-modal" === n &&
                        ((o = (o = window.matchMedia("(min-width: 1025px)").matches) ? ".expanded-menu" : ".mobile-menu"),
                        (t = t.filter(function (e) {
                            return null !== e.closest(o) && null !== e.offsetParent;
                        })).unshift(a.querySelector(".close-main-nav-toggle")),
                        (l = a.querySelector(".menu-bottom > nav")) &&
                            l.querySelectorAll(i).forEach(function (e) {
                                t.push(e);
                            })),
                    (c = t[t.length - 1]),
                    (s = t[0]),
                    (n = a.activeElement),
                    (l = 9 === e.keyCode),
                    !(i = e.shiftKey) && l && c === n && (e.preventDefault(), s.focus()),
                    i && l && s === n && (e.preventDefault(), c.focus()));
            });
        },
    }),
    (coreblog.modalMenu = {
        init: function () {
            this.expandLevel();
        },
        expandLevel: function () {
            document.querySelectorAll(".modal-menu").forEach(function (e) {
                e = e.querySelector(".current-menu-item");
                e &&
                    coreblogFindParents(e, "li").forEach(function (e) {
                        e = e.querySelector(".submenu-toggle");
                        e && coreblog.toggles.performToggle(e, !0);
                    });
            });
        },
    }),
    (coreblog.toggles = {
        clickedEl: !1,
        init: function () {
            this.toggle();
        },
        performToggle: function (e, n) {
            var s,
                l,
                i = this,
                c = document,
                a = e,
                r = a.dataset.toggleTarget,
                d = "active";
            c.querySelectorAll(".show-modal").length || (i.clickedEl = c.activeElement),
                (s = "next" === r ? a.nextSibling : c.querySelector(r)).classList.contains(d)
                    ? s.dispatchEvent(coreblog.createEvent("toggle-target-before-active"))
                    : s.dispatchEvent(coreblog.createEvent("toggle-target-before-inactive")),
                (l = a.dataset.classToToggle || d),
                (e = 0),
                s.classList.contains("cover-modal") && (e = 10),
                setTimeout(function () {
                    var e,
                        t = s.classList.contains("sub-menu") ? a.closest(".menu-item").querySelector(".sub-menu") : s,
                        o = a.dataset.toggleDuration;
                    "slidetoggle" !== a.dataset.toggleType || n || "0" === o ? t.classList.toggle(l) : coreblogMenuToggle(t, o),
                        ("next" === r || s.classList.contains("sub-menu") ? a : c.querySelector('*[data-toggle-target="' + r + '"]')).classList.toggle(d),
                        coreblogToggleAttribute(a, "aria-expanded", "true", "false"),
                        i.clickedEl && -1 !== a.getAttribute("class").indexOf("close-") && coreblogToggleAttribute(i.clickedEl, "aria-expanded", "true", "false"),
                        a.dataset.toggleBodyClass && c.body.classList.toggle(a.dataset.toggleBodyClass),
                        a.dataset.setFocus && (e = c.querySelector(a.dataset.setFocus)) && (s.classList.contains(d) ? e.focus() : e.blur()),
                        s.dispatchEvent(coreblog.createEvent("toggled")),
                        s.classList.contains(d) ? s.dispatchEvent(coreblog.createEvent("toggle-target-after-active")) : s.dispatchEvent(coreblog.createEvent("toggle-target-after-inactive"));
                }, e);
        },
        toggle: function () {
            var o = this;
            document.querySelectorAll("*[data-toggle-target]").forEach(function (t) {
                t.addEventListener("click", function (e) {
                    e.preventDefault(), o.performToggle(t);
                });
            });
        },
    }),
    coreblogDomReady(function () {
        coreblog.toggles.init(), coreblog.coverModals.init();
    });