<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\StoreClientRequest;
use App\Models\Attachment;
use App\Models\Client;
use App\Traits\FileUpload;

class ClientController extends Controller
{
    use FileUpload;

    public function index()
    {
        $limit = request()->input('limit', 10);
        $clients = Client::tableFilter()->paginate($limit, ['*'], 'clients');

        if (request()->ajax()) {
            return $this->sendResponse(view('admin.clients.table')->with('clients', $clients)->render());
        }

        return view('admin.clients.index')->with('clients', $clients);
    }

    public function create()
    {
        $client = null;
        return view('admin.clients.edit')
            ->with('client', $client);
    }

    public function store(StoreClientRequest $request)
    {
        $data = $request->validated();
        $data['creatad_by'] = request()->user()->id;

        if (isset($data['logo_image']) && request()->file('logo_image')) {
            $attachment = $this->uploadFile($data['logo_image']);
            $attachment = Attachment::create($attachment);

            $data['logo_id'] = $attachment->id;
            unset($data['logo_image']);
        }

        $client = Client::create($data);

        return $this->sendResponse($client, t('client added successfully'));
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return $this->sendResponse([], t('client deleted successfully.'));
    }


    public function edit(Client $client)
    {

        return view('admin.clients.edit')
            ->with('client', $client);
    }

    public function update(StoreClientRequest $request, Client $client)
    {
        $data = $request->validated();

        $client->update($data);

        return $this->sendResponse($client, t('client updated successfully'));
    }
}
