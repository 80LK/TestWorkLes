import Home from "./Home";
import Delivery from "./Delivery";
import routes from "./nav_routes";
import E404 from "./Errors/E404";

export default [
    { path: "/", component: Home, name: "Главная" },
    ...routes,
    { path: "/delivery/:id", component: Delivery, name: "Поставка" },
    { path: '*', component: E404, name: "Страница не найдена" }
];
