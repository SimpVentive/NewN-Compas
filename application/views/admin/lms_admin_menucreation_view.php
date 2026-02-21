<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				
                <div class="panel-body">
					<?php
						echo "<div class='cf nestable-lists'><div class='dd myadmin-dd' id='nestable_menu'>";
						echo $menu;
						echo "</div></div>";
					?>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-success" type="button" onClick="create_link('create_menus?id=<?php echo $menu_id."&hash=".md5(SECRET.$menu_id);?>')">Update</button>
							<button class="btn btn-info" type="button" onClick="create_link('create_menus')">New</button>
							<button class="btn btn-danger" type="button" onClick="create_link('menucreation')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>