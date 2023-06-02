var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

export var Search = function (_React$Component) {
    _inherits(Search, _React$Component);

    function Search(p) {
        _classCallCheck(this, Search);

        var _this = _possibleConstructorReturn(this, (Search.__proto__ || Object.getPrototypeOf(Search)).call(this, p));

        _this.fetchData = function (query) {
            var url = '../../src/get-data.php?query=' + query;
            fetch(url).then(function (response) {
                return response.json();
            }).then(function (data) {
                return _this.setState({ responseData: data });
            }).catch(function (error) {
                return console.error(error);
            });
        };

        _this.getList = function () {
            var query = document.getElementById('searchExplore').value;
            var orderby = _this.state.orderby;
            var join = _this.state.join;
            var categories = _this.state.selected_categories;
            var cat = "";
            if (categories.length > 0) {
                cat = "AND fc.category IN (";
                categories.forEach(function (e) {
                    cat += "'" + e.id + "',";
                });
                cat = cat.slice(0, -1);
                cat += ") GROUP BY f.id HAVING COUNT(DISTINCT fc.category) = " + categories.length;
            }

            var fetchString = "SELECT DISTINCT f.* FROM film f, film_category fc, category c " + join + " WHERE fc.film = f.id AND fc.category = c.id " + cat + "AND f.TITLE like '%" + query + "%' " + orderby;
            fetchString = "SELECT DISTINCT f.* FROM film f JOIN film_category fc ON f.id = fc.film JOIN category c ON fc.category = c.id " + join + " WHERE  f.TITLE like '%" + query + "%' " + cat + " " + orderby;
            console.log(fetchString);
            _this.fetchData(fetchString);
        };

        _this.setOrderBy = function () {
            var selected = document.getElementById("filter-box").value;
            console.log(selected);
            if (selected == "Most Popular") {
                _this.setState({
                    orderby: " ORDER BY History.appearances DESC",
                    join: " LEFT JOIN ( SELECT Film, COUNT(*) AS appearances FROM HISTORY_USER GROUP BY Film ORDER BY appearances DESC ) AS History ON f.ID = History.Film "
                });
            } else if (selected == "Release Date") {
                _this.setState({
                    orderby: " ORDER BY RELEASE_DATE",
                    join: ""
                });
            } else {
                _this.setState({
                    orderby: "",
                    join: ""
                });
            }
            _this.getList();
        };

        _this.addCategory = function () {
            var selected = document.getElementById("category-box").value;
            if (selected != "category") {
                var arr = _this.state.selected_categories;
                var cat = _this.state.categories;

                cat.forEach(function (e) {
                    if (e.name == selected) arr.push(e);
                });

                cat = cat.filter(function (e) {
                    return e.name !== selected;
                });

                _this.setState({
                    selected_categories: arr,
                    categories: cat
                });
            }
            document.getElementById("category-box").value = "";
            _this.getList();
        };

        _this.removeCategory = function (name) {
            var arr = _this.state.selected_categories;
            var cat = _this.state.categories;

            arr.forEach(function (e) {
                if (e.name == name) cat.push(e);
            });

            arr = arr.filter(function (e) {
                return e.name !== name;
            });

            _this.setState({
                selected_categories: arr,
                categories: cat
            });
            _this.getList();
        };

        _this.typingTimeout = function () {
            clearTimeout(_this.typingTimer);
            _this.typingTimer = setTimeout(function () {
                _this.getList();
            }, 1000);
        };

        _this.state = {
            responseData: [],
            categories: [],
            selected_categories: [],
            orderby: "",
            join: "",
            timer: null
        };
        return _this;
    }

    _createClass(Search, [{
        key: "componentDidMount",
        value: function componentDidMount() {
            var _this2 = this;

            var url = '../../src/get-data.php?query=SELECT * FROM category';
            fetch(url).then(function (response) {
                return response.json();
            }).then(function (data) {
                return _this2.setState({ categories: data });
            }).catch(function (error) {
                return console.error(error);
            });
        }
    }, {
        key: "render",
        value: function render() {
            var _this3 = this;

            var arr = [];
            var arrCategory = [];
            var arrSelectedCategory = [];

            this.state.responseData.forEach(function (e) {
                var tampilan = React.createElement(
                    "ul",
                    null,
                    React.createElement(
                        "a",
                        { href: "movie.php?film=" + e.id },
                        e.title
                    )
                );
                arr.push(tampilan);
            });

            this.state.categories.forEach(function (e) {
                var tampilan = React.createElement(
                    "option",
                    null,
                    e.name
                );
                arrCategory.push(tampilan);
            });

            this.state.selected_categories.forEach(function (e) {
                var tampilan = React.createElement(
                    "td",
                    { onClick: function onClick() {
                            return _this3.removeCategory(e.name);
                        } },
                    e.name
                );
                arrSelectedCategory.push(tampilan);
            });
            // tampilan yang akan muncul di halaman explore
            return React.createElement(
                "div",
                null,
                React.createElement("input", { onKeyUp: function onKeyUp() {
                        return _this3.typingTimeout();
                    }, type: "text", id: "searchExplore", name: "searchExplore" }),
                React.createElement(
                    "select",
                    { onChange: function onChange() {
                            return _this3.setOrderBy();
                        }, id: "filter-box" },
                    React.createElement(
                        "option",
                        null,
                        "Filter"
                    ),
                    React.createElement(
                        "option",
                        null,
                        "Most Popular"
                    ),
                    React.createElement(
                        "option",
                        null,
                        "Release Date"
                    )
                ),
                React.createElement(
                    "select",
                    { onChange: function onChange() {
                            return _this3.addCategory();
                        }, id: "category-box" },
                    React.createElement(
                        "option",
                        null,
                        "category"
                    ),
                    arrCategory
                ),
                React.createElement(
                    "table",
                    null,
                    React.createElement(
                        "tbody",
                        null,
                        React.createElement(
                            "tr",
                            null,
                            arrSelectedCategory
                        )
                    )
                ),
                React.createElement(
                    "ul",
                    null,
                    arr
                )
            );
            // tampilan yang akan muncul di halaman explore
        }
    }]);

    return Search;
}(React.Component);

var root = ReactDOM.createRoot(document.getElementById("root"));
root.render(React.createElement(Search, null));

// if (window.location.href.includes("../view/explore.php"))
// {
//     root.render(<Search></Search>);
// }