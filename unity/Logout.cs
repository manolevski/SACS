using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using UnityEngine.SceneManagement;

public class Logout : MonoBehaviour
{
	public Button button;
	public string scene;

	void Start ()
	{
		Button btn = button.GetComponent<Button>();
		btn.onClick.AddListener(LogoutAndForget);
	}

	public void LogoutAndForget () {
		PlayerPrefs.DeleteKey ("token");
		SceneManager.LoadScene (scene);
	}

}

