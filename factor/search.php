<div class="row">
    <div class="col-md-1 col-xs-0"></div>
    <form id="form-search">
        <div class="col-md-9 col-xs-10">
            <div class="panel-heading"><input type="search" id="wordSearch" name="wordSearch"
                                              class="form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched"
                                              required="" placeholder="Enter name album, description or picture"
                                              value=""></div>
        </div>
        <div class="col-md-1 col-xs-2">
            <div class="panel-heading">
                <button type="submit" class="btn btn-default pull-right" id="searchbox"><i class="fa fa-search"></i>&nbsp;&nbsp;Search
                </button>
                <br><br>
            </div>
        </div>
    </form>
    <div class="col-md-1 col-xs-0"></div>
</div>

<script>
    $(document).ready(function () {
        var keep;
        function liveSearch() {
            var word = $('#wordSearch').val();
            if(word != ""){
                if(keep != word){
                    keep = word;
                    $("#addPhoto").animate({
                        height: 'hide'
                    });
                    $("#showAlbums").animate({
                        height: 'hide'
                    });
                    $("#showPhoto").animate({
                        height: 'hide'
                    });
                    var urlSearch = "factor/showEvent.php?word="+word;
                    $("#showEvent").load(urlSearch);
                    $("#showEvent").animate({
                        height: 'show'
                    });

                }
            }
        }

        var myVar;
        $('#wordSearch').focus(function () {
            myVar = setInterval(liveSearch, 300);
        });
        $('#wordSearch').blur(function () {
            clearInterval(myVar);
        });


        $("#showSearch").on("submit", "#form-search", function (e) {
            e.preventDefault();
            var word = $('#wordSearch').val();
            if(word != ""){
                if(keep != word){
                    keep = word;
                    $("#addPhoto").animate({
                        height: 'hide'
                    });
                    $("#showAlbums").animate({
                        height: 'hide'
                    });
                    $("#showPhoto").animate({
                        height: 'hide'
                    });
                    var urlSearch = "factor/showEvent.php?word="+word;
                    $("#showEvent").load(urlSearch);
                    $("#showEvent").animate({
                        height: 'show'
                    });
                }
            }
        });
    });
</script>