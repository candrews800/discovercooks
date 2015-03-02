@include ('admin.layout.header')

<div class="row">
    <div class="col-xs-12">
        <h1>Ingredient Sizes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($ingredient_sizes as $ingredient)
                <tr>
                    <td>
                        {{ $ingredient->name }}
                    </td>
                    <td>
                        <a class="btn btn-success" href="#" onclick="editIngredient( {{ $ingredient->id }}, '{{ $ingredient->name }}' )">Edit</a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="#" onclick="deleteIngredient( {{ $ingredient->id }} )">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a class="btn btn-primary" href="#" onclick="newIngredient()">New Size</a>
    </div>
</div>

@include('admin.layout.footer')

<script>
    function newIngredient(){
        var ingredientName = prompt('New Ingredient Name:');

        if(ingredientName != null){
            var url = "{{ url(Request::path()) }}" + "?name=" + ingredientName;
            console.log(url);
            window.location.href = url;
        }
    }

    function deleteIngredient(id){
        var remove = confirm('Are you sure?');

        if(remove){
            var url = "{{ url(Request::path()) }}/delete/" + id;
            window.location.href = url;
        }
    }

    function editIngredient(id, name){
        var ingredientName = prompt('New Ingredient Name:', name);

        if(ingredientName != null){
            var url = "{{ url(Request::path()) }}/edit/" + id + "?name=" + ingredientName;
            console.log(url);
            window.location.href = url;
        }
    }

</script>