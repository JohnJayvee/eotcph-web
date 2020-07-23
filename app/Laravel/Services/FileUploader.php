<?php 

namespace App\Laravel\Services;

/*
*
* Models used for this class
*/

/*
*
* Classes used for this class
*/
use Carbon, Str, File, Image, AzureStorage, URL, Storage;

class FileUploader {

	/**
	*
	*@param Illuminate\Support\Facades\File $file
	*@param string $file_directory
	*
	*@return array
	*/
	public static function upload($file, $file_directory = "uploads",$storage = "file"){
		
		$storage = env('FILE_STORAGE', "file");

		switch (Str::lower($storage)) {
			case 'file':
				// $file = $request->file("file");
				$ext = $file->getClientOriginalExtension()?: "txt";
				$mime_type = $file->getMimeType()?:"plain/text";
				$path_directory = $file_directory."/".Carbon::now()->format('Ymd');

				if (!File::exists($path_directory)){
					File::makeDirectory($path_directory, $mode = 0777, true, true);
				}
				
				$filename = Helper::create_filename($ext);

				$file->move($path_directory, $filename); 

				return [ 
					"path" => Str::lower($file_directory), 
					"directory" => Str::lower(URL::to($path_directory)), 
					"filename" => Str::lower($filename),
					"source" => Str::lower($storage),
					"type" => $mime_type
					
				];

			break;

			case 'azure':
				// $file = $request->file('file');
				$ext = $file->getClientOriginalExtension()?: "txt";
				$mime_type = $file->getMimeType()?:"plain/text";

				$path_directory = "{$file_directory}/".Carbon::now()->format('Ymd');

				if (!File::exists($path_directory)){
					File::makeDirectory($path_directory, $mode = 0777, true, true);
				}


				$filename = Helper::create_filename($ext);
				$new_image_filename = $filename;
				$file->move($path_directory, $filename); 

				
				$client = new AzureStorage(env('BLOB_STORAGE_URL'),env('BLOB_ACCOUNT_NAME'),env('BLOB_ACCESS_KEY'));
				
				$container= env('BLOB_CONTAINER');
				$orig_container = env('BLOB_ORIG_CONTAINER');
				$directory = env('BLOB_STORAGE_URL')."/".env('BLOB_CONTAINER');

				$new_file_directory = "{$directory}/".str_replace("uploads/", "", $path_directory); 
				$new_image_path = str_replace("uploads/", "", $path_directory);
				
				// $client->putBlob($orig_container, "{$new_image_path}/{$filename}", "{$path_directory}/{$filename}",[],null,['x-ms-blob-content-type'     => $mime_type]);
				$client->putBlob($container, "{$new_image_path}/{$filename}", "{$path_directory}/{$filename}",[],null,['x-ms-blob-content-type'     => $mime_type]);
				
			
				if (File::exists("{$path_directory}/{$filename}")){
					File::delete("{$path_directory}/{$filename}");
				}

				return [ 
					"path" => Str::lower($new_image_path), 
					"directory" => Str::lower($new_file_directory), 
					"filename" => Str::lower($new_image_filename),
					"source" => Str::lower($storage),
					"type" => $mime_type

				];
			break;

			case 'aws':
				$ext = $file->getClientOriginalExtension()?: "txt";
				$mime_type = $file->getMimeType()?:"plain/text";
			
				$path_directory = "{$file_directory}/".Carbon::now()->format('Ymd');

				if (!File::exists(public_path($path_directory))){
					File::makeDirectory(public_path($path_directory), $mode = 0777, true, true);
				}

				$filename = Helper::create_filename($ext);
				$new_image_filename = $filename;
				$file->move($path_directory, $filename); 

				$new_image_directory = str_replace("uploads/", "", $path_directory); 
				$new_image_path = str_replace("uploads/", "", $path_directory);
				$directory = env('AWS_CONTAINER')."/".$new_image_path;
				
				Storage::disk('s3')->put("{$new_image_path}/{$filename}",file_get_contents("{$path_directory}/{$filename}"),'public');

				if (File::exists("{$path_directory}/{$filename}")){
					File::delete("{$path_directory}/{$filename}");
				}

				return [ 
					"path" => Str::lower($new_image_path), 
					"directory" => Str::lower($directory), 
					"filename" => Str::lower($new_image_filename),
					"source" => Str::lower($storage),
					"type" => $mime_type
				];

			break;
			
			default:
				return array();
			break;
		}
	}
}