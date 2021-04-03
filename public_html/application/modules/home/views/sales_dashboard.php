<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="row">
		<div class="col-xl-4 col-lg-4 order-lg-2 order-xl-1">
			<div class="row">
				<div class="col-lg-12 col-xl-12">
					<!--begin:: Widgets/Daily Sales-->
					<div class="kt-portlet kt-portlet--height-fluid">
						<div class="kt-widget14">
							<div class="kt-widget14__header kt-margin-b-30">
								<div class="row">
									<div class="col-md-8">
										<h3 class="kt-widget14__title">
											Target vs Achieved
										</h3>	
									</div>
									<div class="col-md-4">
										<div class="row">
											<div class="col-xs-2">
												<select class="form-control">
													<option>Duration</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="kt-widget14__chart">
								<div class="t-speedometer">
									<canvas id="foo"></canvas>
									<span id="gauge1-txt"></span>
								</div>
							</div>

							<style>
								#gauge1-txt {
								    font-weight: bold;
								    font-size:80%;
								    display: block;
								    text-align: center;
								}

								#foo {
									width: 100%;
									height: 100%;
								}
							</style>
						</div>
					</div>
					<!--end:: Widgets/Daily Sales-->	
				</div>

				<div class="col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-lg-6 col-sm-12">
							<div class="kt-portlet kt-portlet--height-fluid">
								<div class="kt-widget14">
									<div class="kt-widget14__header kt-margin-b-30">
										<h3 class="kt-widget14__title">
											Quote to Close ratio
										</h3>
									</div>
									<div class="kt-widget14__chart" style="height:100%;">
										<h1>12 : 19</h1>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-sm-12">
							<div class="kt-portlet kt-portlet--height-fluid">
								<div class="kt-widget14">
									<div class="kt-widget14__header kt-margin-b-30">
										<h3 class="kt-widget14__title">
											Repeat Sales
										</h3>
									</div>
									<div class="kt-widget14__chart" style="height:100%;">
										<h1>60%</h1>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-8 col-lg-8 order-lg-2 order-xl-1">
			<!--begin:: Widgets/Daily Sales-->
			<div class="kt-portlet kt-portlet--height-fluid">
				<div class="kt-widget14">
					<div class="kt-widget14__header kt-margin-b-30">
						<h3 class="kt-widget14__title">
							Sales Growth
						</h3>
					</div>
					<div class="kt-widget14__chart" style="height:100%;">
						<figure class="highcharts-figure">
						    <div id="container-sales-growth"></div>
						</figure>

						<style>
							.highcharts-figure, .highcharts-data-table table {
							    min-width: 360px; 
							    max-width: 800px;
							    margin: 1em auto;
							}

							.highcharts-data-table table {
								font-family: Verdana, sans-serif;
								border-collapse: collapse;
								border: 1px solid #EBEBEB;
								margin: 10px auto;
								text-align: center;
								width: 100%;
								max-width: 500px;
							}
							.highcharts-data-table caption {
							    padding: 1em 0;
							    font-size: 1.2em;
							    color: #555;
							}
							.highcharts-data-table th {
								font-weight: 600;
							    padding: 0.5em;
							}
							.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
							    padding: 0.5em;
							}
							.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
							    background: #f8f8f8;
							}
							.highcharts-data-table tr:hover {
							    background: #f1f7ff;
							}

						</style>
					</div>
				</div>
			</div>
			<!--end:: Widgets/Daily Sales-->
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-xl-12">
			<div class="row">
				<div class="col-lg-3 col-sm-12">
					<div class="kt-portlet kt-portlet--height-fluid">
						<div class="kt-widget14">
							<div class="kt-widget14__header kt-margin-b-30">
								<h3 class="kt-widget14__title">
									Average Order Value
								</h3>
							</div>
							<div class="kt-widget14__chart" style="height:100%;">
								<h1>Rs. 1,23,456</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-12">
					<div class="kt-portlet kt-portlet--height-fluid">
						<div class="kt-widget14">
							<div class="kt-widget14__header kt-margin-b-30">
								<h3 class="kt-widget14__title">
									Sales from New Clients
								</h3>
							</div>
							<div class="kt-widget14__chart" style="height:100%;">
								<h1>120</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-12">
					<div class="kt-portlet kt-portlet--height-fluid">
						<div class="kt-widget14">
							<div class="kt-widget14__header kt-margin-b-30">
								<h3 class="kt-widget14__title">
									Sales from New Clients
								</h3>
							</div>
							<div class="kt-widget14__chart" style="height:100%;">
								<h1>58</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-12">
					<div class="kt-portlet kt-portlet--height-fluid">
						<div class="kt-widget14">
							<div class="kt-widget14__header kt-margin-b-30">
								<h3 class="kt-widget14__title">
									No of inquires generated
								</h3>
							</div>
							<div class="kt-widget14__chart" style="height:100%;">
								<h1>250</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
				<div class="col-xl-6 col-lg-6 order-lg-2 order-xl-1">
			<!--begin:: Widgets/Daily Sales-->
			<div class="kt-portlet kt-portlet--height-fluid">
				<div class="kt-widget14">
					<div class="kt-widget14__header kt-margin-b-30">
						<h3 class="kt-widget14__title">
							Top clients 
						</h3>
					</div>
					<div class="kt-section">
												<span class="kt-section__info">
													Using the most basic table markup, here’s how tables look in Metronic:
												</span>
												<div class="kt-section__content">
													<table class="table">
														<thead>
															<tr>
																<th>#</th>
																<th>First Name</th>
																<th>Last Name</th>
																<th>Username</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<th scope="row">1</th>
																<td>Jhon</td>
																<td>Stone</td>
																<td>@jhon</td>
															</tr>
															<tr>
																<th scope="row">2</th>
																<td>Lisa</td>
																<td>Nilson</td>
																<td>@lisa</td>
															</tr>
															<tr>
																<th scope="row">3</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">4</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">5</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">6</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">7</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">8</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">9</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">10</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										
				</div>
			</div>
			<!--end:: Widgets/Daily Sales-->
		</div>

		<div class="col-xl-6 col-lg-6 order-lg-2 order-xl-1">
			<!--begin:: Widgets/Daily Sales-->
			<div class="kt-portlet kt-portlet--height-fluid">
				<div class="kt-widget14">
					<div class="kt-widget14__header kt-margin-b-30">
						<h3 class="kt-widget14__title">
							Top Sales Leaderboard shared 
						</h3>
					</div>
					<div class="kt-section">
												<span class="kt-section__info">
													Using the most basic table markup, here’s how tables look in Metronic:
												</span>
												<div class="kt-section__content">
													<table class="table">
														<thead>
															<tr>
																<th>#</th>
																<th>First Name</th>
																<th>Last Name</th>
																<th>Username</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<th scope="row">1</th>
																<td>Jhon</td>
																<td>Stone</td>
																<td>@jhon</td>
															</tr>
															<tr>
																<th scope="row">2</th>
																<td>Lisa</td>
																<td>Nilson</td>
																<td>@lisa</td>
															</tr>
															<tr>
																<th scope="row">3</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">4</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">5</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">6</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">7</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">8</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">9</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">10</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										
				</div>
			</div>
			<!--end:: Widgets/Daily Sales-->
		</div>
	</div>

<div class="row">
				<div class="col-xl-6 col-lg-6 order-lg-2 order-xl-1">
			<!--begin:: Widgets/Daily Sales-->
			<div class="kt-portlet kt-portlet--height-fluid">
				<div class="kt-widget14">
					<div class="kt-widget14__header kt-margin-b-30">
						<h3 class="kt-widget14__title">
							Sales by country
						</h3>
					</div>
					<div class="kt-section">
												<span class="kt-section__info">
													Using the most basic table markup, here’s how tables look in Metronic:
												</span>
												<div class="kt-section__content">
													<table class="table">
														<thead>
															<tr>
																<th>#</th>
																<th>First Name</th>
																<th>Last Name</th>
																<th>Username</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<th scope="row">1</th>
																<td>Jhon</td>
																<td>Stone</td>
																<td>@jhon</td>
															</tr>
															<tr>
																<th scope="row">2</th>
																<td>Lisa</td>
																<td>Nilson</td>
																<td>@lisa</td>
															</tr>
															<tr>
																<th scope="row">3</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">4</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">5</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">6</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">7</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">8</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">9</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">10</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										
				</div>
			</div>
			<!--end:: Widgets/Daily Sales-->
		</div>

		<div class="col-xl-6 col-lg-6 order-lg-2 order-xl-1">
			<!--begin:: Widgets/Daily Sales-->
			<div class="kt-portlet kt-portlet--height-fluid">
				<div class="kt-widget14">
					<div class="kt-widget14__header kt-margin-b-30">
						<h3 class="kt-widget14__title">
							Top selling products
						</h3>
					</div>
					<div class="kt-section">
												<span class="kt-section__info">
													Using the most basic table markup, here’s how tables look in Metronic:
												</span>
												<div class="kt-section__content">
													<table class="table">
														<thead>
															<tr>
																<th>#</th>
																<th>First Name</th>
																<th>Last Name</th>
																<th>Username</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<th scope="row">1</th>
																<td>Jhon</td>
																<td>Stone</td>
																<td>@jhon</td>
															</tr>
															<tr>
																<th scope="row">2</th>
																<td>Lisa</td>
																<td>Nilson</td>
																<td>@lisa</td>
															</tr>
															<tr>
																<th scope="row">3</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">4</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">5</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">6</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">7</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">8</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">9</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
															<tr>
																<th scope="row">10</th>
																<td>Larry</td>
																<td>the Bird</td>
																<td>@twitter</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										
				</div>
			</div>
			<!--end:: Widgets/Daily Sales-->
		</div>
	</div>




</div>
