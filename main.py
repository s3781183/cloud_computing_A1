
from google.cloud import datastore

firebase_request_adapter = requests.Request()
# [END gae_python3_auth_verify_token]
# [END gae_python38_auth_verify_token]

datastore_client = datastore.Client()

app = Flask(__name__)


def store_time(dt):
    entity = datastore.Entity(key=datastore_client.key('visit'))
    entity.update({
        'timestamp': dt
    })

    datastore_client.put(entity)


def fetch_times(limit):
    query = datastore_client.query(kind='visit')
    query.order = ['-timestamp']

    times = query.fetch(limit=limit)

    return times

