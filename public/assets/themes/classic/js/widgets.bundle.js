"use strict";
var KTSlidersWidget1 = (function () {
    var e = { self: null, rendered: !1 },
        t = { self: null, rendered: !1 },
        a = { self: null, rendered: !1 },
        l = function (e, t, a) {
            var l = document.querySelector(t);
            if (l && (!0 !== e.rendered || !l.classList.contains("initialized"))) {
                var r = parseInt(KTUtil.css(l, "height")),
                    o = KTUtil.getCssVariableValue("--bs-primary"),
                    i = {
                        series: [a],
                        chart: { fontFamily: "inherit", height: r, type: "radialBar", sparkline: { enabled: !0 } },
                        plotOptions: {
                            radialBar: {
                                hollow: { margin: 0, size: "45%" },
                                dataLabels: { showOn: "always", name: { show: !1 }, value: { show: !1 } },
                                track: {
                                    background: KTUtil.getCssVariableValue("--bs-primary-light"),
                                    strokeWidth: "100%",
                                },
                            },
                        },
                        colors: [o],
                        stroke: { lineCap: "round" },
                        labels: ["Progress"],
                    };
                (e.self = new ApexCharts(l, i)), e.self.render(), (e.rendered = !0), l.classList.add("initialized");
            }
        };
    return {
        init: function () {
            l(e, "#kt_slider_widget_1_chart_1", 76);
            var r = document.querySelector("#kt_sliders_widget_1_slider");
            r &&
                (r.addEventListener("slid.bs.carousel", function (e) {
                    1 === e.to && l(t, "#kt_slider_widget_1_chart_2", 55),
                        2 === e.to && l(a, "#kt_slider_widget_1_chart_3", 25);
                }),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && (e.self.destroy(), (e.rendered = !1)),
                        t.rendered && (t.self.destroy(), (t.rendered = !1)),
                        a.rendered && (a.self.destroy(), (a.rendered = !1)),
                        l(e, "#kt_slider_widget_1_chart_1", 76),
                        l(t, "#kt_slider_widget_1_chart_2", 55),
                        l(a, "#kt_slider_widget_1_chart_3", 25);
                }));
        },
    };
})();
"undefined" != typeof module && (module.exports = KTSlidersWidget1),
    KTUtil.onDOMContentLoaded(function () {
        KTSlidersWidget1.init();
    });
var KTSlidersWidget3 = (function () {
    var e = { self: null, rendered: !1 },
        t = { self: null, rendered: !1 },
        a = function (e, t, a, l) {
            var r = document.querySelector(t);
            if (r && (!0 !== e.rendered || !r.classList.contains("initialized"))) {
                var o = parseInt(KTUtil.css(r, "height")),
                    i = KTUtil.getCssVariableValue("--bs-gray-500"),
                    s = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                    n = KTUtil.getCssVariableValue("--bs-" + a),
                    d = {
                        series: [{ name: "Lessons", data: l }],
                        chart: { fontFamily: "inherit", type: "area", height: o, toolbar: { show: !1 } },
                        plotOptions: {},
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        fill: {
                            type: "gradient",
                            gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 80, 100] },
                        },
                        stroke: { curve: "smooth", show: !0, width: 3, colors: [n] },
                        xaxis: {
                            categories: [
                                "",
                                "Apr 05",
                                "Apr 06",
                                "Apr 07",
                                "Apr 08",
                                "Apr 09",
                                "Apr 11",
                                "Apr 12",
                                "Apr 14",
                                "Apr 15",
                                "Apr 16",
                                "Apr 17",
                                "Apr 18",
                                "",
                            ],
                            axisBorder: { show: !1 },
                            axisTicks: { show: !1 },
                            tickAmount: 6,
                            labels: { rotate: 0, rotateAlways: !0, style: { colors: i, fontSize: "12px" } },
                            crosshairs: { position: "front", stroke: { color: n, width: 1, dashArray: 3 } },
                            tooltip: { enabled: !0, formatter: void 0, offsetY: 0, style: { fontSize: "12px" } },
                        },
                        yaxis: { tickAmount: 4, max: 24, min: 10, labels: { style: { colors: i, fontSize: "12px" } } },
                        states: {
                            normal: { filter: { type: "none", value: 0 } },
                            hover: { filter: { type: "none", value: 0 } },
                            active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } },
                        },
                        tooltip: { style: { fontSize: "12px" } },
                        colors: [n],
                        grid: { borderColor: s, strokeDashArray: 4, yaxis: { lines: { show: !0 } } },
                        markers: { strokeColor: n, strokeWidth: 3 },
                    };
                (e.self = new ApexCharts(r, d)), e.self.render(), (e.rendered = !0), r.classList.add("initialized");
            }
        };
    return {
        init: function () {
            var l = [19, 21, 21, 20, 20, 18, 18, 20, 20, 22, 22, 21, 21, 22],
                r = [18, 22, 22, 20, 20, 18, 18, 20, 20, 18, 18, 20, 20, 22];
            a(e, "#kt_sliders_widget_3_chart_1", "danger", l);
            var o = document.querySelector("#kt_sliders_widget_3_slider");
            o &&
                (o.addEventListener("slid.bs.carousel", function (e) {
                    1 === e.to && a(t, "#kt_sliders_widget_3_chart_2", "primary", r);
                }),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && (e.self.destroy(), (e.rendered = !1)),
                        t.rendered && (t.self.destroy(), (t.rendered = !1)),
                        a(e, "#kt_sliders_widget_3_chart_1", "danger", l),
                        a(t, "#kt_sliders_widget_3_chart_2", "primary", r);
                }));
        },
    };
})();
"undefined" != typeof module && (module.exports = KTSlidersWidget3),
    KTUtil.onDOMContentLoaded(function () {
        KTSlidersWidget3.init();
    });
var KTSlidersWidget7 = (function () {
    var e = { self: null, rendered: !1 },
        t = { self: null, rendered: !1 },
        a = { self: null, rendered: !1 },
        l = function (e, t, a) {
            var l = document.querySelector(t);
            if (l && (!0 !== e.rendered || !l.classList.contains("initialized"))) {
                var r = parseInt(KTUtil.css(l, "height")),
                    o = KTUtil.getCssVariableValue("--bs-danger"),
                    i = {
                        series: [a],
                        chart: { fontFamily: "inherit", height: r, type: "radialBar", sparkline: { enabled: !0 } },
                        plotOptions: {
                            radialBar: {
                                hollow: { margin: 0, size: "45%" },
                                dataLabels: { showOn: "always", name: { show: !1 }, value: { show: !1 } },
                                track: { background: KTUtil.getCssVariableValue("--bs-white"), strokeWidth: "100%" },
                            },
                        },
                        colors: [o],
                        stroke: { lineCap: "round" },
                        labels: ["Progress"],
                    };
                (e.self = new ApexCharts(l, i)), e.self.render(), (e.rendered = !0), l.classList.add("initialized");
            }
        };
    return {
        init: function () {
            l(e, "#kt_slider_widget_7_chart_1", 76);
            var r = document.querySelector("#kt_sliders_widget_7_slider");
            r &&
                (r.addEventListener("slid.bs.carousel", function (e) {
                    1 === e.to && l(t, "#kt_slider_widget_7_chart_2", 55),
                        2 === e.to && l(a, "#kt_slider_widget_7_chart_3", 25);
                }),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && (e.self.destroy(), (e.rendered = !1)),
                        t.rendered && (t.self.destroy(), (t.rendered = !1)),
                        a.rendered && (a.self.destroy(), (a.rendered = !1)),
                        l(e, "#kt_slider_widget_7_chart_1", 76),
                        l(t, "#kt_slider_widget_7_chart_2", 55),
                        l(a, "#kt_slider_widget_7_chart_3", 25);
                }));
        },
    };
})();
"undefined" != typeof module && (module.exports = KTSlidersWidget7),
    KTUtil.onDOMContentLoaded(function () {
        KTSlidersWidget7.init();
    });
var KTTablesWidget14 = (function () {
    var e = { self: null, rendered: !1 },
        t = { self: null, rendered: !1 },
        a = { self: null, rendered: !1 },
        l = { self: null, rendered: !1 },
        r = { self: null, rendered: !1 },
        o = function (e, t, a, l) {
            var r = document.querySelector(t);
            if (r) {
                var o = parseInt(KTUtil.css(r, "height")),
                    i = r.getAttribute("data-kt-chart-color"),
                    s = KTUtil.getCssVariableValue("--bs-gray-300"),
                    n = KTUtil.getCssVariableValue("--bs-" + i),
                    d = KTUtil.getCssVariableValue("--bs-body-bg"),
                    m = {
                        series: [{ name: "Net Profit", data: a }],
                        chart: {
                            fontFamily: "inherit",
                            type: "area",
                            height: o,
                            toolbar: { show: !1 },
                            zoom: { enabled: !1 },
                            sparkline: { enabled: !0 },
                        },
                        plotOptions: {},
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        fill: { type: "solid", opacity: 1 },
                        stroke: { curve: "smooth", show: !0, width: 2, colors: [n] },
                        xaxis: {
                            axisBorder: { show: !1 },
                            axisTicks: { show: !1 },
                            labels: { show: !1 },
                            crosshairs: { show: !1, position: "front", stroke: { color: s, width: 1, dashArray: 3 } },
                            tooltip: { enabled: !1 },
                        },
                        yaxis: { min: 0, max: 60, labels: { show: !1 } },
                        states: {
                            normal: { filter: { type: "none", value: 0 } },
                            hover: { filter: { type: "none", value: 0 } },
                            active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } },
                        },
                        tooltip: { enabled: !1 },
                        colors: [d],
                        markers: { colors: [d], strokeColor: [n], strokeWidth: 3 },
                    };
                (e.self = new ApexCharts(r, m)),
                    !0 === l &&
                        setTimeout(function () {
                            e.self.render(), (e.rendered = !0);
                        }, 200);
            }
        };
    return {
        init: function () {
            var i = [7, 10, 5, 21, 6, 11, 5, 23, 5, 11, 18, 7, 21, 13];
            o(e, "#kt_table_widget_14_chart_1", i, !0);
            var s = [17, 5, 23, 2, 21, 9, 17, 23, 4, 24, 9, 17, 21, 7];
            o(t, "#kt_table_widget_14_chart_2", s, !0);
            var n = [2, 24, 5, 17, 7, 2, 12, 24, 5, 24, 2, 8, 12, 7];
            o(a, "#kt_table_widget_14_chart_3", n, !0);
            var d = [24, 3, 5, 19, 3, 7, 25, 14, 5, 14, 2, 8, 5, 17];
            o(l, "#kt_table_widget_14_chart_4", d, !0);
            var m = [3, 23, 1, 19, 3, 17, 3, 9, 25, 4, 2, 18, 25, 3];
            o(r, "#kt_table_widget_14_chart_5", m, !0),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && e.self.destroy(),
                        t.rendered && t.self.destroy(),
                        a.rendered && a.self.destroy(),
                        l.rendered && l.self.destroy(),
                        r.rendered && r.self.destroy(),
                        o(e, "#kt_table_widget_14_chart_1", i, e.rendered),
                        o(t, "#kt_table_widget_14_chart_2", s, t.rendered),
                        o(a, "#kt_table_widget_14_chart_3", n, a.rendered),
                        o(l, "#kt_table_widget_14_chart_4", d, l.rendered),
                        o(r, "#kt_table_widget_14_chart_5", m, r.rendered);
                });
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTablesWidget14),
    KTUtil.onDOMContentLoaded(function () {
        KTTablesWidget14.init();
    });
var KTTablesWidget15 = (function () {
    var e = { self: null, rendered: !1 },
        t = { self: null, rendered: !1 },
        a = { self: null, rendered: !1 },
        l = { self: null, rendered: !1 },
        r = { self: null, rendered: !1 },
        o = function (e, t, a, l) {
            var r = document.querySelector(t);
            if (r) {
                var o = parseInt(KTUtil.css(r, "height")),
                    i = r.getAttribute("data-kt-chart-color"),
                    s = KTUtil.getCssVariableValue("--bs-gray-300"),
                    n = KTUtil.getCssVariableValue("--bs-" + i),
                    d = KTUtil.getCssVariableValue("--bs-body-bg"),
                    m = {
                        series: [{ name: "Net Profit", data: a }],
                        chart: {
                            fontFamily: "inherit",
                            type: "area",
                            height: o,
                            toolbar: { show: !1 },
                            zoom: { enabled: !1 },
                            sparkline: { enabled: !0 },
                        },
                        plotOptions: {},
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        fill: { type: "solid", opacity: 1 },
                        stroke: { curve: "smooth", show: !0, width: 2, colors: [n] },
                        xaxis: {
                            axisBorder: { show: !1 },
                            axisTicks: { show: !1 },
                            labels: { show: !1 },
                            crosshairs: { show: !1, position: "front", stroke: { color: s, width: 1, dashArray: 3 } },
                            tooltip: { enabled: !1 },
                        },
                        yaxis: { min: 0, max: 60, labels: { show: !1, ontSize: "12px" } },
                        states: {
                            normal: { filter: { type: "none", value: 0 } },
                            hover: { filter: { type: "none", value: 0 } },
                            active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } },
                        },
                        tooltip: { enabled: !1 },
                        colors: [d],
                        markers: { colors: [d], strokeColor: [n], strokeWidth: 3 },
                    };
                (e.self = new ApexCharts(r, m)),
                    !0 === l &&
                        setTimeout(function () {
                            e.self.render(), (e.rendered = !0);
                        }, 200);
            }
        };
    return {
        init: function () {
            var i = [7, 10, 5, 21, 6, 11, 5, 23, 5, 11, 18, 7, 21, 13];
            o(e, "#kt_table_widget_15_chart_1", i, !0);
            var s = [17, 5, 23, 2, 21, 9, 17, 23, 4, 24, 9, 17, 21, 7];
            o(t, "#kt_table_widget_15_chart_2", s, !0);
            var n = [2, 24, 5, 17, 7, 2, 12, 24, 5, 24, 2, 8, 12, 7];
            o(a, "#kt_table_widget_15_chart_3", n, !0);
            var d = [24, 3, 5, 19, 3, 7, 25, 14, 5, 14, 2, 8, 5, 17];
            o(l, "#kt_table_widget_15_chart_4", d, !0);
            var m = [3, 23, 1, 19, 3, 17, 3, 9, 25, 4, 2, 18, 25, 3];
            o(r, "#kt_table_widget_15_chart_5", m, !0),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && e.self.destroy(),
                        t.rendered && t.self.destroy(),
                        a.rendered && a.self.destroy(),
                        l.rendered && l.self.destroy(),
                        r.rendered && r.self.destroy(),
                        o(e, "#kt_table_widget_15_chart_1", i, e.rendered),
                        o(t, "#kt_table_widget_15_chart_2", s, t.rendered),
                        o(a, "#kt_table_widget_15_chart_3", n, a.rendered),
                        o(l, "#kt_table_widget_15_chart_4", d, l.rendered),
                        o(r, "#kt_table_widget_15_chart_5", m, r.rendered);
                });
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTablesWidget15),
    KTUtil.onDOMContentLoaded(function () {
        KTTablesWidget15.init();
    });
var KTTablesWidget16 = (function () {
    var e = { self: null, rendered: !1 },
        t = { self: null, rendered: !1 },
        a = { self: null, rendered: !1 },
        l = { self: null, rendered: !1 },
        r = { self: null, rendered: !1 },
        o = { self: null, rendered: !1 },
        i = { self: null, rendered: !1 },
        s = { self: null, rendered: !1 },
        n = { self: null, rendered: !1 },
        d = { self: null, rendered: !1 },
        m = { self: null, rendered: !1 },
        c = { self: null, rendered: !1 },
        g = { self: null, rendered: !1 },
        f = { self: null, rendered: !1 },
        u = { self: null, rendered: !1 },
        h = { self: null, rendered: !1 },
        p = { self: null, rendered: !1 },
        y = { self: null, rendered: !1 },
        _ = { self: null, rendered: !1 },
        b = { self: null, rendered: !1 },
        v = function (e, t, a, l, r) {
            var o = document.querySelector(a);
            if (o) {
                var i = parseInt(KTUtil.css(o, "height")),
                    s = o.getAttribute("data-kt-chart-color"),
                    n = (KTUtil.getCssVariableValue("--bs-gray-800"), KTUtil.getCssVariableValue("--bs-gray-300")),
                    d = KTUtil.getCssVariableValue("--bs-" + s),
                    m = KTUtil.getCssVariableValue("--bs-body-bg"),
                    c = {
                        series: [{ name: "Net Profit", data: l }],
                        chart: {
                            fontFamily: "inherit",
                            type: "area",
                            height: i,
                            toolbar: { show: !1 },
                            zoom: { enabled: !1 },
                            sparkline: { enabled: !0 },
                        },
                        plotOptions: {},
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        fill: { type: "solid", opacity: 1 },
                        stroke: { curve: "smooth", show: !0, width: 2, colors: [d] },
                        xaxis: {
                            axisBorder: { show: !1 },
                            axisTicks: { show: !1 },
                            labels: { show: !1 },
                            crosshairs: { show: !1, position: "front", stroke: { color: n, width: 1, dashArray: 3 } },
                            tooltip: { enabled: !1 },
                        },
                        yaxis: { min: 0, max: 60, labels: { show: !1, ontSize: "12px" } },
                        states: {
                            normal: { filter: { type: "none", value: 0 } },
                            hover: { filter: { type: "none", value: 0 } },
                            active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } },
                        },
                        tooltip: { enabled: !1 },
                        colors: [m],
                        markers: { colors: [m], strokeColor: [d], strokeWidth: 3 },
                    };
                e.self = new ApexCharts(o, c);
                var g = document.querySelector(t);
                !0 === r &&
                    setTimeout(function () {
                        e.self.render(), (e.rendered = !0);
                    }, 200),
                    g.addEventListener("shown.bs.tab", function (t) {
                        !1 === e.rendered && (e.self.render(), (e.rendered = !0));
                    });
            }
        };
    return {
        init: function () {
            var w = [16, 10, 15, 21, 6, 11, 5, 23, 5, 11, 18, 7, 21, 13];
            v(e, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_1", w, !0);
            var T = [8, 5, 16, 3, 23, 16, 11, 15, 3, 11, 15, 7, 17, 9];
            v(t, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_2", T, !0);
            var k = [8, 6, 16, 3, 23, 16, 11, 14, 3, 11, 15, 8, 17, 9];
            v(a, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_3", k, !0);
            var x = [12, 5, 23, 12, 21, 9, 17, 20, 4, 24, 9, 13, 18, 9];
            v(l, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_4", x, !0);
            var A = [13, 10, 15, 21, 6, 11, 5, 21, 5, 12, 18, 7, 21, 13];
            v(r, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_1", A, !1);
            var C = [13, 5, 21, 12, 21, 9, 17, 20, 4, 23, 9, 17, 21, 7];
            v(o, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_2", C, !1);
            var K = [8, 10, 14, 21, 6, 31, 5, 21, 5, 11, 15, 7, 23, 13];
            v(i, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_3", K, !1);
            var V = [6, 10, 12, 21, 6, 11, 7, 23, 5, 12, 18, 7, 21, 15];
            v(s, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_4", V, !1);
            var S = [7, 10, 5, 21, 6, 11, 5, 23, 5, 11, 18, 7, 21, 13];
            v(n, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_1", S, !1);
            var U = [8, 5, 16, 2, 19, 9, 17, 21, 4, 24, 4, 13, 21, 5];
            v(d, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_2", U, !1);
            var M = [15, 10, 12, 21, 6, 11, 23, 11, 5, 12, 18, 7, 21, 15];
            v(m, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_3", M, !1);
            var W = [3, 9, 12, 23, 6, 11, 7, 23, 5, 12, 14, 7, 21, 8];
            v(c, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_4", W, !1);
            var L = [9, 14, 15, 21, 8, 11, 5, 23, 5, 11, 18, 5, 23, 8];
            v(g, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_1", L, !1);
            var z = [7, 5, 23, 12, 21, 9, 17, 15, 4, 24, 9, 17, 21, 7];
            v(f, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_2", z, !1);
            var D = [8, 10, 14, 21, 6, 31, 8, 23, 5, 3, 14, 7, 21, 12];
            v(u, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_3", D, !1);
            var O = [6, 12, 12, 19, 6, 11, 7, 23, 5, 12, 18, 7, 21, 15];
            v(h, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_4", O, !1);
            var F = [5, 10, 15, 21, 6, 11, 5, 23, 5, 11, 17, 7, 21, 13];
            v(p, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_1", F, !1);
            var I = [4, 5, 23, 12, 21, 9, 17, 15, 4, 24, 9, 17, 21, 7];
            v(y, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_2", I, !1);
            var P = [7, 10, 14, 21, 6, 31, 5, 23, 5, 11, 15, 7, 21, 17];
            v(_, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_3", P, !1);
            var R = [3, 10, 12, 23, 6, 11, 7, 22, 5, 12, 18, 7, 21, 14];
            v(b, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_4", R, !1),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && e.self.destroy(),
                        t.rendered && t.self.destroy(),
                        a.rendered && a.self.destroy(),
                        l.rendered && l.self.destroy(),
                        r.rendered && r.self.destroy(),
                        o.rendered && o.self.destroy(),
                        i.rendered && i.self.destroy(),
                        s.rendered && s.self.destroy(),
                        n.rendered && n.self.destroy(),
                        d.rendered && d.self.destroy(),
                        m.rendered && m.self.destroy(),
                        c.rendered && c.self.destroy(),
                        g.rendered && g.self.destroy(),
                        f.rendered && f.self.destroy(),
                        u.rendered && u.self.destroy(),
                        h.rendered && h.self.destroy(),
                        p.rendered && p.self.destroy(),
                        y.rendered && y.self.destroy(),
                        _.rendered && _.self.destroy(),
                        b.rendered && b.self.destroy(),
                        v(e, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_1", w, e.rendered),
                        v(t, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_2", T, t.rendered),
                        v(a, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_3", k, a.rendered),
                        v(l, "#kt_stats_widget_16_tab_link_1", "#kt_table_widget_16_chart_1_4", x, l.rendered),
                        v(r, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_1", A, r.rendered),
                        v(o, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_2", C, o.rendered),
                        v(i, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_3", K, i.rendered),
                        v(s, "#kt_stats_widget_16_tab_link_2", "#kt_table_widget_16_chart_2_4", V, s.rendered),
                        v(n, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_1", S, n.rendered),
                        v(d, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_2", U, d.rendered),
                        v(m, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_3", M, m.rendered),
                        v(c, "#kt_stats_widget_16_tab_link_3", "#kt_table_widget_16_chart_3_4", W, c.rendered),
                        v(g, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_1", L, g.rendered),
                        v(f, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_2", z, f.rendered),
                        v(u, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_3", D, u.rendered),
                        v(h, "#kt_stats_widget_16_tab_link_4", "#kt_table_widget_16_chart_4_4", O, h.rendered),
                        v(p, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_1", F, p.rendered),
                        v(y, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_2", I, y.rendered),
                        v(_, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_3", P, _.rendered),
                        v(b, "#kt_stats_widget_16_tab_link_5", "#kt_table_widget_16_chart_5_4", R, b.rendered);
                });
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTablesWidget16),
    KTUtil.onDOMContentLoaded(function () {
        KTTablesWidget16.init();
    });
var KTTablesWidget3 = (function () {
    var e, t;
    const a = () => {
        const e = document.querySelector('[data-kt-table-widget-3="filter_status"]');
        $(e).on("select2:select", function (e) {
            const a = $(this).val();
            "Show All" === a ? t.search("").draw() : t.search(a).draw();
        });
    };
    return {
        init: function () {
            (e = document.querySelector("#kt_widget_table_3")) &&
                ((t = $(e).DataTable({ info: !1, order: [], paging: !1, pageLength: !1 })),
                (() => {
                    const e = document
                            .querySelector('[data-kt-table-widget-3="tabs_nav"]')
                            .querySelectorAll('[data-kt-table-widget-3="tab"]'),
                        a = ["border-bottom", "border-3", "border-primary"];
                    e.forEach((l) => {
                        l.addEventListener("click", (r) => {
                            const o = l.getAttribute("data-kt-table-widget-3-value");
                            e.forEach((e) => {
                                e.classList.remove(...a), e.classList.add("text-muted");
                            }),
                                l.classList.remove("text-muted"),
                                l.classList.add(...a),
                                "Show All" === o ? t.search("").draw() : t.search(o).draw();
                        });
                    });
                })(),
                a());
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTablesWidget3),
    KTUtil.onDOMContentLoaded(function () {
        KTTablesWidget3.init();
    });
var KTTablesWidget4 = (function () {
    var e, t, a;
    const l = () => {
            const e = document.querySelector('[data-kt-table-widget-4="filter_status"]');
            $(e).on("select2:select", function (e) {
                const a = $(this).val();
                "Show All" === a ? t.search("").draw() : t.search(a).draw();
            });
        },
        r = [
            {
                image: "76",
                name: "Go Pro 8",
                description: "Latest  version of Go Pro.",
                cost: "500.00",
                qty: "1",
                total: "500.00",
                stock: "12",
            },
            {
                image: "60",
                name: "Bose Earbuds",
                description: "Top quality earbuds from Bose.",
                cost: "300.00",
                qty: "1",
                total: "300.00",
                stock: "8",
            },
            {
                image: "211",
                name: "Dry-fit Sports T-shirt",
                description: "Comfortable sportswear.",
                cost: "89.00",
                qty: "1",
                total: "89.00",
                stock: "18",
            },
            {
                image: "21",
                name: "Apple Airpod 3",
                description: "Apple's latest earbuds.",
                cost: "200.00",
                qty: "2",
                total: "400.00",
                stock: "32",
            },
            {
                image: "83",
                name: "Nike Pumps",
                description: "Apple's latest headphones.",
                cost: "200.00",
                qty: "1",
                total: "200.00",
                stock: "8",
            },
        ],
        o = () => {
            const e = document.querySelectorAll('[data-kt-table-widget-4="expand_row"]'),
                t = [3, 1, 3, 1, 2, 1];
            e.forEach((e, a) => {
                e.addEventListener("click", (l) => {
                    l.stopImmediatePropagation(), l.preventDefault();
                    const o = e.closest("tr"),
                        s = ["isOpen", "border-bottom-0"],
                        n = [];
                    for (var d = 0; d < t[a]; d++) n.push(r[d]);
                    if (o.classList.contains("isOpen")) {
                        for (
                            ;
                            o.nextSibling &&
                            "subtable_template" === o.nextSibling.getAttribute("data-kt-table-widget-4");

                        )
                            o.nextSibling.parentNode.removeChild(o.nextSibling);
                        o.classList.remove(...s), e.classList.remove("active");
                    } else i(n, o), o.classList.add(...s), e.classList.add("active");
                });
            });
        },
        i = (t, l) => {
            t.forEach((r, o) => {
                const i = a.cloneNode(!0),
                    s = i.querySelector('[data-kt-table-widget-4="template_image"]'),
                    n = i.querySelector('[data-kt-table-widget-4="template_name"]'),
                    d = i.querySelector('[data-kt-table-widget-4="template_description"]'),
                    m = i.querySelector('[data-kt-table-widget-4="template_cost"]'),
                    c = i.querySelector('[data-kt-table-widget-4="template_qty"]'),
                    g = i.querySelector('[data-kt-table-widget-4="template_total"]'),
                    f = i.querySelector('[data-kt-table-widget-4="template_stock"]'),
                    u = s.getAttribute("data-kt-src-path");
                s.setAttribute("src", u + r.image + ".png"),
                    (n.innerText = r.name),
                    (d.innerText = r.description),
                    (m.innerText = r.cost),
                    (c.innerText = r.qty),
                    (g.innerText = r.total),
                    r.stock > 10
                        ? (f.innerHTML = '<div class="badge badge-light-success">In Stock</div>')
                        : (f.innerHTML = '<div class="badge badge-light-warning">Low Stock</div>'),
                    1 === t.length || t.length;
                e.querySelector("tbody").insertBefore(i, l.nextSibling);
            });
        },
        s = () => {
            document.querySelectorAll('[data-kt-table-widget-4="subtable_template"]').forEach((e) => {
                e.parentNode.removeChild(e);
            });
            e.querySelectorAll("tbody tr").forEach((e) => {
                e.classList.remove("isOpen"),
                    e.querySelector('[data-kt-table-widget-4="expand_row"]') &&
                        e.querySelector('[data-kt-table-widget-4="expand_row"]').classList.remove("active");
            });
        };
    return {
        init: function () {
            (e = document.querySelector("#kt_table_widget_4_table")) &&
                ((() => {
                    const l = document.querySelector('[data-kt-table-widget-4="subtable_template"]');
                    (a = l.cloneNode(!0)).classList.remove("d-none"),
                        l.parentNode.removeChild(l),
                        (t = $(e).DataTable({
                            info: !1,
                            order: [],
                            lengthChange: !1,
                            pageLength: 6,
                            ordering: !1,
                            paging: !1,
                            columnDefs: [
                                { orderable: !1, targets: 0 },
                                { orderable: !1, targets: 6 },
                            ],
                        })).on("draw", function () {
                            s(), o();
                        });
                })(),
                document.querySelector('[data-kt-table-widget-4="search"]').addEventListener("keyup", function (e) {
                    t.search(e.target.value).draw();
                }),
                l(),
                o());
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTablesWidget4),
    KTUtil.onDOMContentLoaded(function () {
        KTTablesWidget4.init();
    });
var KTTablesWidget5 = (function () {
    var e, t;
    const a = () => {
        const e = document.querySelector('[data-kt-table-widget-5="filter_status"]');
        $(e).on("select2:select", function (e) {
            const a = $(this).val();
            "Show All" === a ? t.search("").draw() : t.search(a).draw();
        });
    };
    return {
        init: function () {
            (e = document.querySelector("#kt_table_widget_5_table")) &&
                (e.querySelectorAll("tbody tr").forEach((e) => {
                    const t = e.querySelectorAll("td"),
                        a = moment(t[2].innerHTML, "MMM DD, YYYY").format();
                    t[2].setAttribute("data-order", a);
                }),
                (t = $(e).DataTable({
                    info: !1,
                    order: [],
                    lengthChange: !1,
                    pageLength: 6,
                    paging: !1,
                    columnDefs: [{ orderable: !1, targets: 1 }],
                })),
                a());
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTablesWidget5),
    KTUtil.onDOMContentLoaded(function () {
        KTTablesWidget5.init();
    });
var KTTimelineWidget1 = (function () {
    const e = () => {
            document.querySelectorAll('[data-kt-timeline-widget-1="tab"]').forEach((e) => {
                e.addEventListener("shown.bs.tab", (a) => {
                    "#kt_timeline_widget_1_tab_week" === e.getAttribute("href") &&
                        (() => {
                            const e = document.querySelector("#kt_timeline_widget_1_2");
                            if (!e) return;
                            if (e.innerHTML) return;
                            var a = Date.now(),
                                l = e.getAttribute("data-kt-timeline-widget-1-image-root"),
                                r = new vis.DataSet([
                                    { id: 1, content: "Research", order: 1 },
                                    { id: 2, content: "Phase 2.6 QA", order: 2 },
                                    { id: 3, content: "UI Design", order: 3 },
                                    { id: 4, content: "Development", order: 4 },
                                ]),
                                o = new vis.DataSet([
                                    {
                                        id: 1,
                                        group: 1,
                                        start: a,
                                        end: moment(a).add(7, "days"),
                                        content: "Framework",
                                        progress: "71%",
                                        color: "primary",
                                        users: ["avatars/300-6.jpg", "avatars/300-1.jpg"],
                                    },
                                    {
                                        id: 2,
                                        group: 2,
                                        start: moment(a).add(7, "days"),
                                        end: moment(a).add(14, "days"),
                                        content: "Accessibility",
                                        progress: "84%",
                                        color: "success",
                                        users: ["avatars/300-2.jpg"],
                                    },
                                    {
                                        id: 3,
                                        group: 3,
                                        start: moment(a).add(3, "days"),
                                        end: moment(a).add(20, "days"),
                                        content: "Microsites",
                                        progress: "69%",
                                        color: "danger",
                                        users: ["avatars/300-5.jpg", "avatars/300-20.jpg"],
                                    },
                                    {
                                        id: 4,
                                        group: 4,
                                        start: moment(a).add(10, "days"),
                                        end: moment(a).add(21, "days"),
                                        content: "Deployment",
                                        progress: "74%",
                                        color: "info",
                                        users: ["avatars/300-23.jpg", "avatars/300-12.jpg", "avatars/300-9.jpg"],
                                    },
                                ]),
                                i = {
                                    zoomable: !1,
                                    moveable: !1,
                                    selectable: !1,
                                    margin: { item: { horizontal: 10, vertical: 35 } },
                                    showCurrentTime: !1,
                                    xss: {
                                        disabled: !1,
                                        filterOptions: {
                                            whiteList: {
                                                div: ["class", "style"],
                                                img: ["data-kt-timeline-avatar-src", "alt"],
                                                a: ["href", "class"],
                                            },
                                        },
                                    },
                                    template: function (e) {
                                        const t = e.users;
                                        let a = "";
                                        return (
                                            t.forEach((e) => {
                                                a += `<div class="symbol symbol-circle symbol-25px"><img data-kt-timeline-avatar-src="${l + e}" alt="" /></div>`;
                                            }),
                                            `<div class="rounded-pill bg-light-${e.color} d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">\n                    <div class="position-absolute rounded-pill d-block bg-${e.color} start-0 top-0 h-100 z-index-1" style="width: ${e.progress};"></div>\n        \n                    <div class="d-flex align-items-center position-relative z-index-2">\n                        <div class="symbol-group symbol-hover flex-nowrap me-3">\n                            ${a}\n                        </div>\n        \n                        <a href="#" class="fw-bold text-white text-hover-dark">${e.content}</a>\n                    </div>\n        \n                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">\n                        ${e.progress}\n                    </div>\n                </div>        \n                `
                                        );
                                    },
                                    onInitialDrawComplete: function () {
                                        t();
                                        const a = e.closest('[data-kt-timeline-widget-1-blockui="true"]'),
                                            l = KTBlockUI.getInstance(a);
                                        l.isBlocked() &&
                                            setTimeout(() => {
                                                l.release();
                                            }, 1e3);
                                    },
                                };
                            const s = new vis.Timeline(e, o, r, i);
                            s.on("currentTimeTick", () => {
                                s.off("currentTimeTick");
                            });
                        })(),
                        "#kt_timeline_widget_1_tab_month" === e.getAttribute("href") &&
                            (() => {
                                const e = document.querySelector("#kt_timeline_widget_1_3");
                                if (!e) return;
                                if (e.innerHTML) return;
                                var a = Date.now(),
                                    l = e.getAttribute("data-kt-timeline-widget-1-image-root"),
                                    r = new vis.DataSet([
                                        { id: "research", content: "Research", order: 1 },
                                        { id: "qa", content: "Phase 2.6 QA", order: 2 },
                                        { id: "ui", content: "UI Design", order: 3 },
                                        { id: "dev", content: "Development", order: 4 },
                                    ]),
                                    o = new vis.DataSet([
                                        {
                                            id: 1,
                                            group: "research",
                                            start: a,
                                            end: moment(a).add(2, "months"),
                                            content: "Tags",
                                            progress: "79%",
                                            color: "primary",
                                            users: ["avatars/300-6.jpg", "avatars/300-1.jpg"],
                                        },
                                        {
                                            id: 2,
                                            group: "qa",
                                            start: moment(a).add(0.5, "months"),
                                            end: moment(a).add(5, "months"),
                                            content: "Testing",
                                            progress: "64%",
                                            color: "success",
                                            users: ["avatars/300-2.jpg"],
                                        },
                                        {
                                            id: 3,
                                            group: "ui",
                                            start: moment(a).add(2, "months"),
                                            end: moment(a).add(6.5, "months"),
                                            content: "Media",
                                            progress: "82%",
                                            color: "danger",
                                            users: ["avatars/300-5.jpg", "avatars/300-20.jpg"],
                                        },
                                        {
                                            id: 4,
                                            group: "dev",
                                            start: moment(a).add(4, "months"),
                                            end: moment(a).add(7, "months"),
                                            content: "Plugins",
                                            progress: "58%",
                                            color: "info",
                                            users: ["avatars/300-23.jpg", "avatars/300-12.jpg", "avatars/300-9.jpg"],
                                        },
                                    ]),
                                    i = {
                                        zoomable: !1,
                                        moveable: !1,
                                        selectable: !1,
                                        margin: { item: { horizontal: 10, vertical: 35 } },
                                        showCurrentTime: !1,
                                        xss: {
                                            disabled: !1,
                                            filterOptions: {
                                                whiteList: {
                                                    div: ["class", "style"],
                                                    img: ["data-kt-timeline-avatar-src", "alt"],
                                                    a: ["href", "class"],
                                                },
                                            },
                                        },
                                        template: function (e) {
                                            const t = e.users;
                                            let a = "";
                                            return (
                                                t.forEach((e) => {
                                                    a += `<div class="symbol symbol-circle symbol-25px"><img data-kt-timeline-avatar-src="${l + e}" alt="" /></div>`;
                                                }),
                                                `<div class="rounded-pill bg-light-${e.color} d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">\n                    <div class="position-absolute rounded-pill d-block bg-${e.color} start-0 top-0 h-100 z-index-1" style="width: ${e.progress};"></div>\n        \n                    <div class="d-flex align-items-center position-relative z-index-2">\n                        <div class="symbol-group symbol-hover flex-nowrap me-3">\n                            ${a}\n                        </div>\n        \n                        <a href="#" class="fw-bold text-white text-hover-dark">${e.content}</a>\n                    </div>\n        \n                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">\n                        ${e.progress}\n                    </div>\n                </div>        \n                `
                                            );
                                        },
                                        onInitialDrawComplete: function () {
                                            t();
                                            const a = e.closest('[data-kt-timeline-widget-1-blockui="true"]'),
                                                l = KTBlockUI.getInstance(a);
                                            l.isBlocked() &&
                                                setTimeout(() => {
                                                    l.release();
                                                }, 1e3);
                                        },
                                    };
                                const s = new vis.Timeline(e, o, r, i);
                                s.on("currentTimeTick", () => {
                                    s.off("currentTimeTick");
                                });
                            })();
                });
            });
        },
        t = () => {
            const e = document.querySelectorAll("[data-kt-timeline-avatar-src]");
            e &&
                e.forEach((e) => {
                    e.setAttribute("src", e.getAttribute("data-kt-timeline-avatar-src")),
                        e.removeAttribute("data-kt-timeline-avatar-src");
                });
        };
    return {
        init: function () {
            (() => {
                const e = document.querySelector("#kt_timeline_widget_1_1");
                if (!e) return;
                if (e.innerHTML) return;
                var a = Date.now(),
                    l = e.getAttribute("data-kt-timeline-widget-1-image-root"),
                    r = new vis.DataSet([
                        { id: "research", content: "Research", order: 1 },
                        { id: "qa", content: "Phase 2.6 QA", order: 2 },
                        { id: "ui", content: "UI Design", order: 3 },
                        { id: "dev", content: "Development", order: 4 },
                    ]),
                    o = new vis.DataSet([
                        {
                            id: 1,
                            group: "research",
                            start: a,
                            end: moment(a).add(1.5, "hours"),
                            content: "Meeting",
                            progress: "60%",
                            color: "primary",
                            users: ["avatars/300-6.jpg", "avatars/300-1.jpg"],
                        },
                        {
                            id: 2,
                            group: "qa",
                            start: moment(a).add(1, "hours"),
                            end: moment(a).add(2, "hours"),
                            content: "Testing",
                            progress: "47%",
                            color: "success",
                            users: ["avatars/300-2.jpg"],
                        },
                        {
                            id: 3,
                            group: "ui",
                            start: moment(a).add(30, "minutes"),
                            end: moment(a).add(2.5, "hours"),
                            content: "Landing page",
                            progress: "55%",
                            color: "danger",
                            users: ["avatars/300-5.jpg", "avatars/300-20.jpg"],
                        },
                        {
                            id: 4,
                            group: "dev",
                            start: moment(a).add(1.5, "hours"),
                            end: moment(a).add(3, "hours"),
                            content: "Products module",
                            progress: "75%",
                            color: "info",
                            users: ["avatars/300-23.jpg", "avatars/300-12.jpg", "avatars/300-9.jpg"],
                        },
                    ]),
                    i = {
                        zoomable: !1,
                        moveable: !1,
                        selectable: !1,
                        margin: { item: { horizontal: 10, vertical: 35 } },
                        showCurrentTime: !1,
                        xss: {
                            disabled: !1,
                            filterOptions: {
                                whiteList: {
                                    div: ["class", "style"],
                                    img: ["data-kt-timeline-avatar-src", "alt"],
                                    a: ["href", "class"],
                                },
                            },
                        },
                        template: function (e) {
                            const t = e.users;
                            let a = "";
                            return (
                                t.forEach((e) => {
                                    a += `<div class="symbol symbol-circle symbol-25px"><img data-kt-timeline-avatar-src="${l + e}" alt="" /></div>`;
                                }),
                                `<div class="rounded-pill bg-light-${e.color} d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">\n                    <div class="position-absolute rounded-pill d-block bg-${e.color} start-0 top-0 h-100 z-index-1" style="width: ${e.progress};"></div>\n        \n                    <div class="d-flex align-items-center position-relative z-index-2">\n                        <div class="symbol-group symbol-hover flex-nowrap me-3">\n                            ${a}\n                        </div>\n        \n                        <a href="#" class="fw-bold text-white text-hover-dark">${e.content}</a>\n                    </div>\n        \n                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">\n                        ${e.progress}\n                    </div>\n                </div>        \n                `
                            );
                        },
                        onInitialDrawComplete: function () {
                            t();
                            const a = e.closest('[data-kt-timeline-widget-1-blockui="true"]'),
                                l = KTBlockUI.getInstance(a);
                            l.isBlocked() &&
                                setTimeout(() => {
                                    l.release();
                                }, 1e3);
                        },
                    };
                const s = new vis.Timeline(e, o, r, i);
                s.on("currentTimeTick", () => {
                    s.off("currentTimeTick");
                });
            })(),
                document.querySelectorAll('[data-kt-timeline-widget-1-blockui="true"]').forEach((e) => {
                    new KTBlockUI(e, { overlayClass: "bg-body" }).block();
                }),
                e();
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTimelineWidget1),
    KTUtil.onDOMContentLoaded(function () {
        KTTimelineWidget1.init();
    });
var KTTimelineWidget2 = {
    init: function () {
        var e;
        (e = document.querySelector("#kt_timeline_widget_2_card")) &&
            KTUtil.on(e, '[data-kt-element="checkbox"]', "change", function (e) {
                var t = this.closest(".form-check"),
                    a = this.closest("tr"),
                    l = a.querySelector('[data-kt-element="bullet"]'),
                    r = a.querySelector('[data-kt-element="status"]');
                !0 === this.checked
                    ? (t.classList.add("form-check-success"),
                      l.classList.remove("bg-primary"),
                      l.classList.add("bg-success"),
                      (r.innerText = "Done"),
                      r.classList.remove("badge-light-primary"),
                      r.classList.add("badge-light-success"))
                    : (t.classList.remove("form-check-success"),
                      l.classList.remove("bg-success"),
                      l.classList.add("bg-primary"),
                      (r.innerText = "In Process"),
                      r.classList.remove("badge-light-success"),
                      r.classList.add("badge-light-primary"));
            });
    },
};
"undefined" != typeof module && (module.exports = KTTimelineWidget2),
    KTUtil.onDOMContentLoaded(function () {
        KTTimelineWidget2.init();
    });
var KTTimelineWidget4 = (function () {
    const e = () => {
            document.querySelectorAll('[data-kt-timeline-widget-4="tab"]').forEach((e) => {
                e.addEventListener("shown.bs.tab", (a) => {
                    "#kt_timeline_widget_4_tab_week" === e.getAttribute("href") &&
                        (() => {
                            const e = document.querySelector("#kt_timeline_widget_4_2");
                            if (!e) return;
                            if (e.innerHTML) return;
                            var a = Date.now(),
                                l = e.getAttribute("data-kt-timeline-widget-4-image-root"),
                                r = new vis.DataSet([
                                    { id: 1, content: "Research", order: 1 },
                                    { id: 2, content: "Phase 2.6 QA", order: 2 },
                                    { id: 3, content: "UI Design", order: 3 },
                                    { id: 4, content: "Development", order: 4 },
                                ]),
                                o = new vis.DataSet([
                                    {
                                        id: 1,
                                        group: 1,
                                        start: a,
                                        end: moment(a).add(7, "days"),
                                        content: "Framework",
                                        progress: "71%",
                                        color: "primary",
                                        users: ["avatars/300-6.jpg", "avatars/300-1.jpg"],
                                    },
                                    {
                                        id: 2,
                                        group: 2,
                                        start: moment(a).add(7, "days"),
                                        end: moment(a).add(14, "days"),
                                        content: "Accessibility",
                                        progress: "84%",
                                        color: "success",
                                        users: ["avatars/300-2.jpg"],
                                    },
                                    {
                                        id: 3,
                                        group: 3,
                                        start: moment(a).add(3, "days"),
                                        end: moment(a).add(20, "days"),
                                        content: "Microsites",
                                        progress: "69%",
                                        color: "danger",
                                        users: ["avatars/300-5.jpg", "avatars/300-20.jpg"],
                                    },
                                    {
                                        id: 4,
                                        group: 4,
                                        start: moment(a).add(10, "days"),
                                        end: moment(a).add(21, "days"),
                                        content: "Deployment",
                                        progress: "74%",
                                        color: "info",
                                        users: ["avatars/300-23.jpg", "avatars/300-12.jpg", "avatars/300-9.jpg"],
                                    },
                                ]),
                                i = {
                                    zoomable: !1,
                                    moveable: !1,
                                    selectable: !1,
                                    margin: { item: { horizontal: 10, vertical: 35 } },
                                    showCurrentTime: !1,
                                    xss: {
                                        disabled: !1,
                                        filterOptions: {
                                            whiteList: {
                                                div: ["class", "style"],
                                                img: ["data-kt-timeline-avatar-src", "alt"],
                                                a: ["href", "class"],
                                            },
                                        },
                                    },
                                    template: function (e) {
                                        const t = e.users;
                                        let a = "";
                                        return (
                                            t.forEach((e) => {
                                                a += `<div class="symbol symbol-circle symbol-25px"><img data-kt-timeline-avatar-src="${l + e}" alt="" /></div>`;
                                            }),
                                            `<div class="rounded-pill bg-light-${e.color} d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">\n                    <div class="position-absolute rounded-pill d-block bg-${e.color} start-0 top-0 h-100 z-index-1" style="width: ${e.progress};"></div>\n        \n                    <div class="d-flex align-items-center position-relative z-index-2">\n                        <div class="symbol-group symbol-hover flex-nowrap me-3">\n                            ${a}\n                        </div>\n        \n                        <a href="#" class="fw-bold text-white text-hover-dark">${e.content}</a>\n                    </div>\n        \n                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">\n                        ${e.progress}\n                    </div>\n                </div>        \n                `
                                        );
                                    },
                                    onInitialDrawComplete: function () {
                                        t();
                                        const a = e.closest('[data-kt-timeline-widget-4-blockui="true"]'),
                                            l = KTBlockUI.getInstance(a);
                                        l.isBlocked() &&
                                            setTimeout(() => {
                                                l.release();
                                            }, 1e3);
                                    },
                                };
                            const s = new vis.Timeline(e, o, r, i);
                            s.on("currentTimeTick", () => {
                                s.off("currentTimeTick");
                            });
                        })(),
                        "#kt_timeline_widget_4_tab_month" === e.getAttribute("href") &&
                            (() => {
                                const e = document.querySelector("#kt_timeline_widget_4_3");
                                if (!e) return;
                                if (e.innerHTML) return;
                                var a = Date.now(),
                                    l = e.getAttribute("data-kt-timeline-widget-4-image-root"),
                                    r = new vis.DataSet([
                                        { id: "research", content: "Research", order: 1 },
                                        { id: "qa", content: "Phase 2.6 QA", order: 2 },
                                        { id: "ui", content: "UI Design", order: 3 },
                                        { id: "dev", content: "Development", order: 4 },
                                    ]),
                                    o = new vis.DataSet([
                                        {
                                            id: 1,
                                            group: "research",
                                            start: a,
                                            end: moment(a).add(2, "months"),
                                            content: "Tags",
                                            progress: "79%",
                                            color: "primary",
                                            users: ["avatars/300-6.jpg", "avatars/300-1.jpg"],
                                        },
                                        {
                                            id: 2,
                                            group: "qa",
                                            start: moment(a).add(0.5, "months"),
                                            end: moment(a).add(5, "months"),
                                            content: "Testing",
                                            progress: "64%",
                                            color: "success",
                                            users: ["avatars/300-2.jpg"],
                                        },
                                        {
                                            id: 3,
                                            group: "ui",
                                            start: moment(a).add(2, "months"),
                                            end: moment(a).add(6.5, "months"),
                                            content: "Media",
                                            progress: "82%",
                                            color: "danger",
                                            users: ["avatars/300-5.jpg", "avatars/300-20.jpg"],
                                        },
                                        {
                                            id: 4,
                                            group: "dev",
                                            start: moment(a).add(4, "months"),
                                            end: moment(a).add(7, "months"),
                                            content: "Plugins",
                                            progress: "58%",
                                            color: "info",
                                            users: ["avatars/300-23.jpg", "avatars/300-12.jpg", "avatars/300-9.jpg"],
                                        },
                                    ]),
                                    i = {
                                        zoomable: !1,
                                        moveable: !1,
                                        selectable: !1,
                                        margin: { item: { horizontal: 10, vertical: 35 } },
                                        showCurrentTime: !1,
                                        xss: {
                                            disabled: !1,
                                            filterOptions: {
                                                whiteList: {
                                                    div: ["class", "style"],
                                                    img: ["data-kt-timeline-avatar-src", "alt"],
                                                    a: ["href", "class"],
                                                },
                                            },
                                        },
                                        template: function (e) {
                                            const t = e.users;
                                            let a = "";
                                            return (
                                                t.forEach((e) => {
                                                    a += `<div class="symbol symbol-circle symbol-25px"><img data-kt-timeline-avatar-src="${l + e}" alt="" /></div>`;
                                                }),
                                                `<div class="rounded-pill bg-light-${e.color} d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">\n                    <div class="position-absolute rounded-pill d-block bg-${e.color} start-0 top-0 h-100 z-index-1" style="width: ${e.progress};"></div>\n        \n                    <div class="d-flex align-items-center position-relative z-index-2">\n                        <div class="symbol-group symbol-hover flex-nowrap me-3">\n                            ${a}\n                        </div>\n        \n                        <a href="#" class="fw-bold text-white text-hover-dark">${e.content}</a>\n                    </div>\n        \n                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">\n                        ${e.progress}\n                    </div>\n                </div>        \n                `
                                            );
                                        },
                                        onInitialDrawComplete: function () {
                                            t();
                                            const a = e.closest('[data-kt-timeline-widget-4-blockui="true"]'),
                                                l = KTBlockUI.getInstance(a);
                                            l.isBlocked() &&
                                                setTimeout(() => {
                                                    l.release();
                                                }, 1e3);
                                        },
                                    };
                                const s = new vis.Timeline(e, o, r, i);
                                s.on("currentTimeTick", () => {
                                    s.off("currentTimeTick");
                                });
                            })(),
                        "#kt_timeline_widget_4_tab_2022" === e.getAttribute("href") &&
                            (() => {
                                const e = document.querySelector("#kt_timeline_widget_4_4");
                                if (!e) return;
                                if (e.innerHTML) return;
                                var a = Date.now(),
                                    l = e.getAttribute("data-kt-timeline-widget-4-image-root"),
                                    r = new vis.DataSet([
                                        { id: "research", content: "Research", order: 1 },
                                        { id: "qa", content: "Phase 2.6 QA", order: 2 },
                                        { id: "ui", content: "UI Design", order: 3 },
                                        { id: "dev", content: "Development", order: 4 },
                                    ]),
                                    o = new vis.DataSet([
                                        {
                                            id: 1,
                                            group: "research",
                                            start: a,
                                            end: moment(a).add(2, "months"),
                                            content: "Tags",
                                            progress: "51%",
                                            color: "primary",
                                            users: ["avatars/300-7.jpg", "avatars/300-2.jpg"],
                                        },
                                        {
                                            id: 2,
                                            group: "qa",
                                            start: moment(a).add(0.5, "months"),
                                            end: moment(a).add(5, "months"),
                                            content: "Testing",
                                            progress: "64%",
                                            color: "success",
                                            users: ["avatars/300-2.jpg"],
                                        },
                                        {
                                            id: 3,
                                            group: "ui",
                                            start: moment(a).add(2, "months"),
                                            end: moment(a).add(6.5, "months"),
                                            content: "Media",
                                            progress: "54%",
                                            color: "danger",
                                            users: ["avatars/300-5.jpg", "avatars/300-21.jpg"],
                                        },
                                        {
                                            id: 4,
                                            group: "dev",
                                            start: moment(a).add(4, "months"),
                                            end: moment(a).add(7, "months"),
                                            content: "Plugins",
                                            progress: "348%",
                                            color: "info",
                                            users: ["avatars/300-3.jpg", "avatars/300-11.jpg", "avatars/300-13.jpg"],
                                        },
                                    ]),
                                    i = {
                                        zoomable: !1,
                                        moveable: !1,
                                        selectable: !1,
                                        margin: { item: { horizontal: 10, vertical: 35 } },
                                        showCurrentTime: !1,
                                        xss: {
                                            disabled: !1,
                                            filterOptions: {
                                                whiteList: {
                                                    div: ["class", "style"],
                                                    img: ["data-kt-timeline-avatar-src", "alt"],
                                                    a: ["href", "class"],
                                                },
                                            },
                                        },
                                        template: function (e) {
                                            const t = e.users;
                                            let a = "";
                                            return (
                                                t.forEach((e) => {
                                                    a += `<div class="symbol symbol-circle symbol-25px"><img data-kt-timeline-avatar-src="${l + e}" alt="" /></div>`;
                                                }),
                                                `<div class="rounded-pill bg-light-${e.color} d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">\n                    <div class="position-absolute rounded-pill d-block bg-${e.color} start-0 top-0 h-100 z-index-1" style="width: ${e.progress};"></div>\n        \n                    <div class="d-flex align-items-center position-relative z-index-2">\n                        <div class="symbol-group symbol-hover flex-nowrap me-3">\n                            ${a}\n                        </div>\n        \n                        <a href="#" class="fw-bold text-white text-hover-dark">${e.content}</a>\n                    </div>\n        \n                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">\n                        ${e.progress}\n                    </div>\n                </div>        \n                `
                                            );
                                        },
                                        onInitialDrawComplete: function () {
                                            t();
                                            const a = e.closest('[data-kt-timeline-widget-4-blockui="true"]'),
                                                l = KTBlockUI.getInstance(a);
                                            l.isBlocked() &&
                                                setTimeout(() => {
                                                    l.release();
                                                }, 1e3);
                                        },
                                    };
                                const s = new vis.Timeline(e, o, r, i);
                                s.on("currentTimeTick", () => {
                                    s.off("currentTimeTick");
                                });
                            })();
                });
            });
        },
        t = () => {
            const e = document.querySelectorAll("[data-kt-timeline-avatar-src]");
            e &&
                e.forEach((e) => {
                    e.setAttribute("src", e.getAttribute("data-kt-timeline-avatar-src")),
                        e.removeAttribute("data-kt-timeline-avatar-src");
                });
        };
    return {
        init: function () {
            (() => {
                const e = document.querySelector("#kt_timeline_widget_4_1");
                if (!e) return;
                if (e.innerHTML) return;
                var a = Date.now(),
                    l = e.getAttribute("data-kt-timeline-widget-4-image-root"),
                    r = new vis.DataSet([
                        { id: "research", content: "Research", order: 1 },
                        { id: "qa", content: "Phase 2.6 QA", order: 2 },
                        { id: "ui", content: "UI Design", order: 3 },
                        { id: "dev", content: "Development", order: 4 },
                    ]),
                    o = new vis.DataSet([
                        {
                            id: 1,
                            group: "research",
                            start: a,
                            end: moment(a).add(1.5, "hours"),
                            content: "Meeting",
                            progress: "60%",
                            color: "primary",
                            users: ["avatars/300-6.jpg", "avatars/300-1.jpg"],
                        },
                        {
                            id: 2,
                            group: "qa",
                            start: moment(a).add(1, "hours"),
                            end: moment(a).add(2, "hours"),
                            content: "Testing",
                            progress: "47%",
                            color: "success",
                            users: ["avatars/300-2.jpg"],
                        },
                        {
                            id: 3,
                            group: "ui",
                            start: moment(a).add(30, "minutes"),
                            end: moment(a).add(2.5, "hours"),
                            content: "Landing page",
                            progress: "55%",
                            color: "danger",
                            users: ["avatars/300-5.jpg", "avatars/300-20.jpg"],
                        },
                        {
                            id: 4,
                            group: "dev",
                            start: moment(a).add(1.5, "hours"),
                            end: moment(a).add(3, "hours"),
                            content: "Products module",
                            progress: "75%",
                            color: "info",
                            users: ["avatars/300-23.jpg", "avatars/300-12.jpg", "avatars/300-9.jpg"],
                        },
                    ]),
                    i = {
                        zoomable: !1,
                        moveable: !1,
                        selectable: !1,
                        margin: { item: { horizontal: 10, vertical: 35 } },
                        showCurrentTime: !1,
                        xss: {
                            disabled: !1,
                            filterOptions: {
                                whiteList: {
                                    div: ["class", "style"],
                                    img: ["data-kt-timeline-avatar-src", "alt"],
                                    a: ["href", "class"],
                                },
                            },
                        },
                        template: function (e) {
                            const t = e.users;
                            let a = "";
                            return (
                                t.forEach((e) => {
                                    a += `<div class="symbol symbol-circle symbol-25px"><img data-kt-timeline-avatar-src="${l + e}" alt="" /></div>`;
                                }),
                                `<div class="rounded-pill bg-light-${e.color} d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">\n                    <div class="position-absolute rounded-pill d-block bg-${e.color} start-0 top-0 h-100 z-index-1" style="width: ${e.progress};"></div>\n        \n                    <div class="d-flex align-items-center position-relative z-index-2">\n                        <div class="symbol-group symbol-hover flex-nowrap me-3">\n                            ${a}\n                        </div>\n        \n                        <a href="#" class="fw-bold text-white text-hover-dark">${e.content}</a>\n                    </div>\n        \n                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">\n                        ${e.progress}\n                    </div>\n                </div>        \n                `
                            );
                        },
                        onInitialDrawComplete: function () {
                            t();
                            const a = e.closest('[data-kt-timeline-widget-4-blockui="true"]'),
                                l = KTBlockUI.getInstance(a);
                            l.isBlocked() &&
                                setTimeout(() => {
                                    l.release();
                                }, 1e3);
                        },
                    };
                const s = new vis.Timeline(e, o, r, i);
                s.on("currentTimeTick", () => {
                    s.off("currentTimeTick");
                });
            })(),
                document.querySelectorAll('[data-kt-timeline-widget-4-blockui="true"]').forEach((e) => {
                    new KTBlockUI(e, { overlayClass: "bg-body" }).block();
                }),
                e();
        },
    };
})();
"undefined" != typeof module && (module.exports = KTTimelineWidget4),
    KTUtil.onDOMContentLoaded(function () {
        KTTimelineWidget4.init();
    });
