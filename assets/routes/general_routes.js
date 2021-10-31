import Home from "./Home";
import routes from "./nav_routes";
import E404 from "./Errors/E404";

export default [
    {path: "/", component: Home, name: "Главная"},
    ...routes,
    {path: '*', component: E404, name: "Страница не найдена"}
];