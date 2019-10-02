<?php
	$message = "";
	$msg = preg_replace('#[^a-z 0-9.:_()]#i', '', $_GET['msg']);

	if($msg == "activation_failure"){
		$message = 'Activation Error: Sorry there seems to have been an issue activating your account at this time. We have already notified ourselves of this issue and we will contact you via email when we have identified the issue.';
	}

	else if($msg == "activation_success"){
		$message = 'Activation Success: Your account is now activated.<br> <a href="login.php">Click here to log in</a>';
	}

	else {
		$message = $msg;
	}

?>

<html>
<head>
	<title> Repaw | Failed </title>
	<link rel="stylesheet" href="style/login-fail.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
</head>
<body>
<div class="all-wrap">
	<div class="all">
		<div class="yarn"></div>
		<div class="cat-wrap">
			<div class="cat">
				<div class="cat-upper">
					<div class="cat-leg"></div>
					<div class="cat-leg"></div>
					<div class="cat-head">
						<div class="cat-ears">
							<div class="cat-ear"></div>
							<div class="cat-ear"></div>
						</div>
						<div class="cat-face">
							<div class="cat-eyes"></div>
							<div class="cat-mouth"></div>
							<div class="cat-whiskers"></div>
						</div>
					</div>
				</div>
				<div class="cat-lower-wrap">
					<div class="cat-lower">
						<div class="cat-leg">
							<div class="cat-leg">
								<div class="cat-leg">
									<div class="cat-leg">
										<div class="cat-leg">
											<div class="cat-leg">
												<div class="cat-leg">
													<div class="cat-leg">
														<div class="cat-leg">
															<div class="cat-leg">
																<div class="cat-leg">
																	<div class="cat-leg">
																		<div class="cat-leg">
																			<div class="cat-leg">
																				<div class="cat-leg">
																					<div class="cat-leg">
																						<div class="cat-paw"></div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="cat-leg">
							<div class="cat-leg">
								<div class="cat-leg">
									<div class="cat-leg">
										<div class="cat-leg">
											<div class="cat-leg">
												<div class="cat-leg">
													<div class="cat-leg">
														<div class="cat-leg">
															<div class="cat-leg">
																<div class="cat-leg">
																	<div class="cat-leg">
																		<div class="cat-leg">
																			<div class="cat-leg">
																				<div class="cat-leg">
																					<div class="cat-leg">
																						<div class="cat-paw"></div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="cat-tail">
							<div class="cat-tail">
								<div class="cat-tail">
									<div class="cat-tail">
										<div class="cat-tail">
											<div class="cat-tail">
												<div class="cat-tail">
													<div class="cat-tail">
														<div class="cat-tail">
															<div class="cat-tail">
																<div class="cat-tail">
																	<div class="cat-tail">
																		<div class="cat-tail">
																			<div class="cat-tail">
																				<div class="cat-tail">
																					<div class="cat-tail -end"></div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


	<div class="center">
		<div class="text-center">
			<?php echo $message; ?>
		</div>
	</div>
</body>
</html>
