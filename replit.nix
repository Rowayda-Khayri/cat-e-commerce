{ pkgs }: {
	deps = [
   pkgs.mysql80
   pkgs.php80Packages.composer
		pkgs.php82
	];
}