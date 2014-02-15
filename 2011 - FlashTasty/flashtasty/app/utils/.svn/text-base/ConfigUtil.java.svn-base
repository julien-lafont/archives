package utils;

import play.Play;

public class ConfigUtil {

	public static Integer getInt(String key) {
		return Integer.parseInt( Play.configuration.getProperty(key) );
	}

	public static Integer getInt(String key, Integer def) {
		return Integer.parseInt( Play.configuration.getProperty(key, def.toString()) );
	}


}
