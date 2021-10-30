import Home from "./Home";
import routes from "./nav_routes";

export default [
    { path:"/", component:Home, name: "Главная" },
    ...routes
];