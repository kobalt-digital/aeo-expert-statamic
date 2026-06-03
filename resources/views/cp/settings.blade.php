@extends('statamic::layout')
@section('title', 'AEO Expert')

@section('content')
    <div class="card p-4 mb-4">
        <h1 class="text-2xl font-bold mb-2">AEO Expert</h1>
        <p class="text-gray-600 mb-4">
            Boost your AI-readiness score. All settings are managed via
            <code class="bg-gray-100 px-1 rounded">config/aeo-expert.php</code>.
        </p>

        <div class="divider my-4"></div>

        <h2 class="text-lg font-bold mb-3">Active Endpoints</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Endpoint</th>
                    <th>URL</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>llms.txt</td>
                    <td><a href="{{ url('/llms.txt') }}" target="_blank">{{ url('/llms.txt') }}</a></td>
                    <td>{!! $config['llms_txt_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                </tr>
                <tr>
                    <td>robots.txt (AI bots)</td>
                    <td><a href="{{ url('/robots.txt') }}" target="_blank">{{ url('/robots.txt') }}</a></td>
                    <td>{!! $config['robots_ai_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                </tr>
                <tr>
                    <td>.well-known/mcp</td>
                    <td><a href="{{ url('/.well-known/mcp') }}" target="_blank">{{ url('/.well-known/mcp') }}</a></td>
                    <td>{!! $config['mcp_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                </tr>
                <tr>
                    <td>.well-known/security.txt</td>
                    <td><a href="{{ url('/.well-known/security.txt') }}" target="_blank">{{ url('/.well-known/security.txt') }}</a></td>
                    <td>{!! $config['security_txt_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                </tr>
                <tr>
                    <td>.well-known/agent-skills.json</td>
                    <td><a href="{{ url('/.well-known/agent-skills.json') }}" target="_blank">{{ url('/.well-known/agent-skills.json') }}</a></td>
                    <td>{!! $config['agent_skills_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                </tr>
                <tr>
                    <td>.well-known/api-catalog</td>
                    <td><a href="{{ url('/.well-known/api-catalog') }}" target="_blank">{{ url('/.well-known/api-catalog') }}</a></td>
                    <td>{!! $config['api_catalog_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                </tr>
            </tbody>
        </table>

        <div class="divider my-4"></div>

        <h2 class="text-lg font-bold mb-3">Features</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Feature</th>
                    <th>Status</th>
                    <th>Usage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Organization Schema</td>
                    <td>{!! $config['schema_org_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td><code>@{{ aeo_schema:organization }}</code></td>
                </tr>
                <tr>
                    <td>Meta Description</td>
                    <td>{!! $config['meta_tags_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td><code>@{{ aeo_meta }}</code></td>
                </tr>
                <tr>
                    <td>Open Graph</td>
                    <td>{!! $config['open_graph_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td><code>@{{ aeo_og }}</code></td>
                </tr>
                <tr>
                    <td>FAQ Schema</td>
                    <td>{!! $config['faq_schema_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td><code>@{{ aeo_faq :items="faq_items" }}</code></td>
                </tr>
                <tr>
                    <td>Security Headers</td>
                    <td>{!! $config['security_headers_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td>Automatic (middleware)</td>
                </tr>
                <tr>
                    <td>HSTS</td>
                    <td>{!! $config['hsts_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td>Automatic (middleware)</td>
                </tr>
                <tr>
                    <td>Link Headers</td>
                    <td>{!! $config['link_headers_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td>Automatic (middleware)</td>
                </tr>
                <tr>
                    <td>Markdown Variant</td>
                    <td>{!! $config['markdown_variant_enabled'] ? '<span class="text-green-500">Enabled</span>' : '<span class="text-gray-400">Disabled</span>' !!}</td>
                    <td>Append <code>?format=md</code> to any entry URL</td>
                </tr>
            </tbody>
        </table>

        <div class="divider my-4"></div>

        <h2 class="text-lg font-bold mb-3">AI Bot Rules</h2>
        @if($config['robots_ai_enabled'] && !empty($config['robots_ai_bots']))
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bot</th>
                        <th>Rule</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($config['robots_ai_bots'] as $bot => $action)
                        <tr>
                            <td>{{ $bot }}</td>
                            <td>
                                @if($action === 'allow')
                                    <span class="text-green-500">Allow</span>
                                @else
                                    <span class="text-red-500">Disallow</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-400">AI bot rules disabled.</p>
        @endif
    </div>
@endsection
