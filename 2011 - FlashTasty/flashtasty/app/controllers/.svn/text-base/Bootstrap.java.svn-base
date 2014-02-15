package controllers;

import helpers.LoremHelper;
import helpers.PhotoHelper;
import play.mvc.Before;
import play.mvc.Controller;

public class Bootstrap extends Controller {

	/**
	 * Injection des données avant l'appel au template
	 */
	@Before
	public static void bootStrap() {
		renderArgs.put("photoHelper", new PhotoHelper());
		renderArgs.put("loremHelper", new LoremHelper());
	}
}
