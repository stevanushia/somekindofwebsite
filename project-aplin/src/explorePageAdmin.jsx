export class Search extends React.Component {
    constructor(p){
        super(p)
        this.state = {
            responseData: [],
            categories : [],
            selected_categories : [],
            orderby : "",
            join : "",
            timer: null
        };
    }

    componentDidMount(){
        const url = '../../src/get-data.php?query=SELECT * FROM category';
        fetch(url)
        .then(response => response.json())
        .then(data => this.setState({ categories: data }))
        .catch(error => console.error(error));
    }

    fetchData = (query) => {
        const url = '../../src/get-data.php?query=' + query;
        fetch(url)
        .then(response => response.json())
        .then(data => this.setState({ responseData: data }))
        .catch(error => console.error(error));
    }

    getList = () => {
        let query = document.getElementById('searchExplore').value;
        let orderby = this.state.orderby;
        let join = this.state.join;
        let categories = this.state.selected_categories;
        let cat = "";
        if (categories.length > 0)
        {
            cat = "AND fc.category IN ("
            categories.forEach((e) => {
                cat += "'"+e.id+"',";
            })
            cat = cat.slice(0, -1);
            cat += ") GROUP BY f.id HAVING COUNT(DISTINCT fc.category) = "+categories.length;
        }

        let fetchString = "SELECT DISTINCT f.* FROM film f, film_category fc, category c "+join+" WHERE fc.film = f.id AND fc.category = c.id "+cat+"AND f.TITLE like '%"+query+"%' "+orderby;
        fetchString = "SELECT DISTINCT f.* FROM film f JOIN film_category fc ON f.id = fc.film JOIN category c ON fc.category = c.id "+join+" WHERE  f.TITLE like '%"+query+"%' "+cat+" "+orderby;
        console.log(fetchString);
        this.fetchData(fetchString);
    }

    setOrderBy = () => {
        let selected = document.getElementById("filter-box").value;
        console.log(selected);
        if (selected == "Most Popular")
        {
            this.setState({
                orderby: " ORDER BY History.appearances DESC",
                join: " LEFT JOIN ( SELECT Film, COUNT(*) AS appearances FROM HISTORY_USER GROUP BY Film ORDER BY appearances DESC ) AS History ON f.ID = History.Film "
            });
        }
        else if (selected == "Release Date")
        {
            this.setState({
                orderby: " ORDER BY RELEASE_DATE",
                join: ""
            });
        }
        else {
            this.setState({
                orderby: "",
                join: ""
            })
        }
        this.getList();
    }

    addCategory = () => {
        let selected = document.getElementById("category-box").value;
        if (selected != "category")    
        {
            let arr = this.state.selected_categories;
            let cat = this.state.categories;

            cat.forEach((e) => {
                if (e.name == selected) arr.push(e);
            })

            cat = cat.filter(function(e) {
                return e.name !== selected;
            });
            
            this.setState({
                selected_categories: arr,
                categories: cat
            })
        }
        document.getElementById("category-box").value = "";
        this.getList();
    }

    removeCategory = (name) => {
        let arr = this.state.selected_categories;
        let cat = this.state.categories;

        arr.forEach((e) => {
            if (e.name == name) cat.push(e);
        })

        arr = arr.filter(function(e) {
            return e.name !== name;
        });
        
        this.setState({
            selected_categories: arr,
            categories: cat
        })
        this.getList();
    }

    typingTimeout = () => {
        clearTimeout(this.typingTimer);
        this.typingTimer = setTimeout(() => {
            this.getList();
        }, 1000);
    }

    render() {
        let arr = []
        let arrCategory = []
        let arrSelectedCategory = []

        this.state.responseData.forEach((e) => {
            let tampilan = <ul><a href={"movie.php?film="+e.id}>{e.title}</a></ul>;
            arr.push(tampilan)
        })

        this.state.categories.forEach((e) => {
            let tampilan = <option>{e.name}</option>; 
            arrCategory.push(tampilan)
        })

        this.state.selected_categories.forEach(e => {
            let tampilan = <td onClick={() => this.removeCategory(e.name)}>{e.name}</td>; 
            arrSelectedCategory.push(tampilan);
        });
        // tampilan yang akan muncul di halaman explore
        return (
            <div>
                <input onKeyUp={() => this.typingTimeout()} type="text" id="searchExplore" name="searchExplore"/>
                <select onChange={() => this.setOrderBy()} id="filter-box">
                    <option>Filter</option>
                    <option>Most Popular</option>
                    <option>Release Date</option>
                </select>
                <select onChange={() => this.addCategory()} id="category-box"> 
                    <option>category</option>
                        {arrCategory}
                </select>
                <table>
                    <tbody>
                        <tr>
                            {arrSelectedCategory}
                        </tr>
                    </tbody>
                </table>
                <ul>
                    {arr}
                </ul>
            </div>
        );
        // tampilan yang akan muncul di halaman explore

    }

}

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<Search></Search>);

// if (window.location.href.includes("../view/explore.php"))
// {
//     root.render(<Search></Search>);
// }

