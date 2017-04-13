using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using UnityEngine.SceneManagement;
using System;
using System.Security.Cryptography;
using System.IO;
using System.Text;

public class AccessControl : MonoBehaviour {

	public string accessScene;
	public Button button;
	public InputField inputField;
	public string apiUrl;
	public string key;
	public Text outputLabel;
	public Toggle rememberMe;

	private Text txt;
	private string token;
	private string iv = "45287112549354892144548565456541";

	public void Start()
	{
		txt = outputLabel.GetComponent<Text> ();
		Button btn = button.GetComponent<Button>();
		btn.onClick.AddListener(Submit);

		token = PlayerPrefs.GetString ("token");
		if (!string.IsNullOrEmpty (token))
			Submit ();
			
	}

	public void Submit () {
		InputField inp = inputField.GetComponent<InputField> ();
		string token = string.IsNullOrEmpty(inp.text) ? this.token : inp.text;
		if (!string.IsNullOrEmpty (token))
			Get (apiUrl + token);
		else
			txt.text = "Required field!";
	}

	public WWW Get(string url)
	{
		WWW www = new WWW (url);
		StartCoroutine (WaitForRequest (www));
		return www; 
	}

	private IEnumerator WaitForRequest(WWW www)
	{
		yield return www;
		// check for errors
		if (www.error == null)
		{
			if (!string.IsNullOrEmpty (www.text)) {
				string response = DecryptRJ256(Decode(www.text), key, iv);
				User user = JsonUtility.FromJson<User> (response);
				CheckAccess (user);
			}
			else
				txt.text = "Wrong code!";
		} else {
			txt.text = "Network error!";
			Debug.Log("Error: "+ www.error);
		}    
	}

	private void CheckAccess(User user)
	{		
		if (user == null) {
			txt.text = "Error!";
			return;
		}

		if (user.allow) {
			Toggle rememberMeVariable = rememberMe.GetComponent<Toggle> ();
			if (rememberMeVariable.isOn) {
				PlayerPrefs.SetString ("token", user.token);
				PlayerPrefs.Save ();
			}			
			SceneManager.LoadScene (accessScene);
		}
		else
			txt.text = "Access denied!";
	}

	public byte[] Decode(string str)
	{
		var decbuff = Convert.FromBase64String(str);
		return decbuff;
	}

	static public String DecryptRJ256(byte[] cypher, string KeyString, string IVString)
	{
		var sRet = "";

		var encoding = new UTF8Encoding();
		var Key = encoding.GetBytes(KeyString);
		var IV = encoding.GetBytes(IVString);

		using (var rj = new RijndaelManaged())
		{
			try
			{
				rj.Padding = PaddingMode.PKCS7;
				rj.Mode = CipherMode.CBC;
				rj.KeySize = 256;
				rj.BlockSize = 256;
				rj.Key = Key;
				rj.IV = IV;
				var ms = new MemoryStream(cypher);

				using (var cs = new CryptoStream(ms, rj.CreateDecryptor(Key, IV), CryptoStreamMode.Read))
				{
					using (var sr = new StreamReader(cs))
					{
						sRet = sr.ReadLine();
					}
				}
			}
			finally
			{
				rj.Clear();
			}
		}

		return sRet;
	}
}

[Serializable]
public class User
{
	public string name;
	public string email;
	public string token;
	public bool allow;
	public int timestamp;
}
