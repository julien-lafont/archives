package helpers;

import play.mvc.Controller;

public class LoremHelper extends Controller {

	public String ipsum (int nb) {
		return texte.substring(0, nb);
	}


	private static final String texte =
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed lorem neque, non feugiat velit. Nullam rhoncus elit nunc. Vestibulum gravida, lacus non dictum placerat, sem lorem fermentum nunc, quis varius massa orci in nulla. Fusce sollicitudin congue nisl, ut interdum purus aliquam et. Mauris aliquet bibendum erat ultrices dictum. Donec vehicula convallis egestas. Donec id massa non nulla ultrices scelerisque nec non lacus. Pellentesque a turpis sit amet metus iaculis tempus. Sed quis arcu erat, nec vestibulum nulla. In pulvinar aliquam auctor. Duis ullamcorper volutpat eros a auctor. Aliquam in neque eros, rhoncus feugiat sapien."+
		"Etiam vitae mi risus. Sed quis semper libero. Nulla sit amet libero sed dolor aliquam pulvinar eu vel felis. Ut vestibulum risus ut dolor auctor venenatis. Suspendisse ullamcorper placerat eleifend. Aenean et leo odio. Donec urna odio, ultricies vel convallis vel, volutpat vitae tellus. Mauris imperdiet porttitor mi ut rutrum. Sed ornare, dui sagittis dictum lacinia, neque urna vehicula tortor, et suscipit dolor arcu nec justo. Vivamus ac velit quam, eu interdum est. Donec sodales mauris odio. Donec a leo non nisi accumsan facilisis a eu lacus. Sed sed urna lorem, id pretium arcu."+
		"Integer sed aliquam nisl. Maecenas sit amet dui lectus, vitae ornare elit. Integer lorem turpis, euismod ut lacinia a, iaculis quis orci. Nam laoreet interdum elit. Nullam interdum vehicula elit, vel dapibus dolor rutrum non. Nulla pellentesque posuere urna sit amet viverra. Sed eu nulla dui, at rhoncus nibh. Nunc imperdiet aliquet condimentum. Aliquam id luctus ligula. Donec elementum risus in velit imperdiet ornare. In semper semper tellus, sit amet eleifend mi pretium vitae. In adipiscing fermentum quam nec condimentum. Nam et egestas est. Aliquam ultrices lacus sit amet est pulvinar commodo. Vestibulum dictum elit in arcu vestibulum consectetur."+
		"Suspendisse sit amet dui dolor, sit amet porttitor metus. Vivamus luctus faucibus varius. Curabitur eget odio nec dui bibendum eleifend. Phasellus ornare consectetur vulputate. Aliquam sagittis commodo lacus non elementum. Suspendisse quam lacus, ornare non consectetur ac, facilisis vitae nulla. In ullamcorper egestas congue. Aliquam semper semper lacus, non faucibus ipsum luctus ut. Nullam mattis ante vel est consectetur nec rutrum risus facilisis. Maecenas molestie libero dapibus dui ullamcorper et rhoncus est vestibulum. Etiam commodo tortor id purus dictum in eleifend dui suscipit. Fusce fringilla pharetra mattis. In porta turpis quis odio porta luctus. Praesent eu ornare ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas blandit varius faucibus. Pellentesque egestas nisi ac nunc adipiscing scelerisque. Praesent congue suscipit ullamcorper. Sed posuere, ipsum aliquam mattis placerat, nisi nunc eleifend eros, eget semper massa ipsum eget leo. Duis a mauris sit amet metus bibendum volutpat a nec augue."+
		"Aliquam sem turpis, bibendum id bibendum sed, fringilla nec massa. Etiam odio sem, egestas quis ullamcorper vitae, hendrerit mollis eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum sem metus, viverra et mollis pulvinar, placerat vitae sem. Curabitur lacinia enim id tellus pellentesque interdum. Pellentesque nibh felis, aliquet in placerat eget, congue nec mi. Suspendisse ut tempor velit. In tempor, augue eget lacinia venenatis, est lacus rutrum enim, a accumsan elit arcu rhoncus lorem. Quisque sit amet quam id mi ultrices tempor quis id nulla. Integer dictum consectetur eleifend. Maecenas sed turpis ut tellus elementum pulvinar. In hac habitasse platea dictumst. Sed faucibus, erat non consectetur sollicitudin, urna elit iaculis lacus, nec bibendum sem risus nec lorem. Proin justo nulla, pharetra sed commodo scelerisque, malesuada eu diam. Nulla accumsan libero vel lacus feugiat adipiscing. Proin id mi dui, fringilla porta odio. Ut risus elit, lacinia sit amet euismod a, eleifend at nibh. In fringilla, felis sed congue pretium, odio dui scelerisque nunc, sed blandit purus eros a mauris. Nunc ut orci ante, at vehicula massa. Maecenas ultrices, lacus vitae pretium convallis, ipsum augue tempus quam, ac semper magna nibh a magna.";
}