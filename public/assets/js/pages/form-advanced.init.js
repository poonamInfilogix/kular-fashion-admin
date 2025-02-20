! function (s) {
    "use strict";

    function e() {}
    e.prototype.init = function () {
       s("#colorpicker-default").spectrum(), s("#colorpicker-showalpha").spectrum({
          showAlpha: !0
       }), s("#colorpicker-showpaletteonly").spectrum({
          showPaletteOnly: !0,
          showPalette: !0,
          color: "#34c38f",
          palette: [
             ["#556ee6", "white", "#34c38f", "rgb(255, 128, 0);", "#50a5f1"],
             ["red", "yellow", "green", "blue", "violet"]
          ]
       }), s("#colorpicker-togglepaletteonly").spectrum({
          showPaletteOnly: !0,
          togglePaletteOnly: !0,
          togglePaletteMoreText: "more",
          togglePaletteLessText: "less",
          color: "#556ee6",
          palette: [
             ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
             ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
             ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
             ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
             ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
             ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
             ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
             ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
          ]
       }), s("#colorpicker-showintial").spectrum({
          showInitial: !0
       }), s("#colorpicker-showinput-intial").spectrum({
          showInitial: !0,
          showInput: !0
       })
       const colorMap = {
        "red": "#ff0000", "green": "#00ff00", "blue": "#0000ff", "yellow": "#ffff00", "cyan": "#00ffff",
        "magenta": "#ff00ff", "black": "#000000", "white": "#ffffff", "violet": "#ee82ee", "orange": "#ff7f00", "purple": "#800080",
        "pink": "#ffc0cb", "brown": "#a52a2a", "gray": "#808080", "lightgray": "#d3d3d3", "darkgray": "#a9a9a9", "gold": "#ffd700",
        "silver": "#c0c0c0", "beige": "#f5f5dc", "peach": "#ffe5b4", "lavender": "#e6e6fa", "turquoise": "#40e0d0", "coral": "#ff7f50", "salmon": "#fa8072",
        "tomato": "#ff6347", "chartreuse": "#7fff00", "olive": "#808000", "teal": "#008080", "navy": "#000080", "indigo": "#4b0082",
        "khaki": "#f0e68c", "plum": "#dda0dd", "orchid": "#da70d6", "slategray": "#708090", "lightblue": "#add8e6", "lightgreen": "#90ee90",
        "darkgreen": "#006400", "crimson": "#dc143c", "firebrick": "#b22222", "mintcream": "#f5fffa", "antiquewhite": "#faebd7", "linen": "#faf0e6", "seashell": "#fff5ee", "mistyrose": "#ffe4e1"
    };
    
    s("#color_name").on('input', function () {
        const colorName = s(this).val().toLowerCase();
        if (colorMap[colorName]) {
            const colorHex = colorMap[colorName];
            s("#colorpicker-showinput-intial").spectrum("set", colorHex);
            s("#colorpicker-showinput-intial").val(colorHex);
        }
    });

    }, s.AdvancedForm = new e, s.AdvancedForm.Constructor = e
 }(window.jQuery),
 
 function () {
    "use strict";
    window.jQuery.AdvancedForm.init()
 }(), $(function () {
    "use strict";
     $(".docs-actions").on("click", "button", function (e) {
        alert('dfsdf');
       var t, a = $(this).data(),
       i = a.arguments || [];
       console.log(a);
       e.stopPropagation(), a.method && ($(a.source).val()) && a.target && $(a.target).val(t)
    })
});