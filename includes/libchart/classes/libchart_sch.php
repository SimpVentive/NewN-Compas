<?php
	/* Libchart - PHP chart library
	 * Copyright (C) 2005-2008 Jean-Marc Trémeaux (jm.tremeaux at gmail.com)
	 * 
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 * 
	 */
	require_once 'model_sch/Point.php';
	require_once 'model_sch/DataSet.php';
	require_once 'model_sch/XYDataSet.php';
	require_once 'model_sch/XYSeriesDataSet.php';
	
	require_once 'view_sch/primitive/Padding.php';
	require_once 'view_sch/primitive/Rectangle.php';
	require_once 'view_sch/primitive/Primitive.php';
	require_once 'view_sch/text/Text.php';
	require_once 'view_sch/color/Color.php';
	require_once 'view_sch/color/ColorSet.php';
	require_once 'view_sch/color/Palette.php';
	require_once 'view_sch/axis/Bound.php';
	require_once 'view_sch/axis/Axis.php';
	require_once 'view_sch/plot/Plot.php';
	require_once 'view_sch/caption/Caption.php';
	require_once 'view_sch/chart/Chart.php';
	require_once 'view_sch/chart/BarChart.php';
	require_once 'view_sch/chart/VerticalBarChart.php';
	require_once 'view_sch/chart/HorizontalBarChart.php';
	require_once 'view_sch/chart/LineChart.php';
	require_once 'view_sch/chart/PieChart.php';
?>