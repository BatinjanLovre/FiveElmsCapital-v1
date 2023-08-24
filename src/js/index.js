//STYLE
import "../sass/style.scss";


//JS
import "./global";

function importAll(r) {
    r.keys().forEach(r);
}

importAll(require.context("../js/methods/", true, /\.js$/));
importAll(require.context("../js/plugins/", true, /\.js$/));

